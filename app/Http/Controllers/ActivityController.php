<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Inertia\Inertia;
use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Affiche la page du tableau de bord avec la liste des activités.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $activities = Activity::with(['category', 'user'])->withCount('participants')->get();
        $categories = Category::all();
        return Inertia::render('Dashboard', ['activities' =>$activities, "categories" => $categories]);
    }

    /**
     * Récupère les activités avec leurs distances par rapport aux coordonnées de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activitiesWithDistances(Request $request)
    {
        // Récupère les coordonnées de l'utilisateur depuis la requête
        $userLat = floatval($request->input('lat'));
        $userLon = floatval($request->input('lon'));

        // Récupère toutes les activités avec leurs catégories, utilisateurs et le nombre de participants
        $activities = Activity::with(['category', 'user'])->withCount('participants')->get();

        // Calcule et ajoute la distance de chaque activité par rapport aux coordonnées de l'utilisateur
        foreach ($activities as $activity) {
            $activity->distance = $this->distance($userLat, $userLon, floatval($activity->lat), floatval($activity->lon));
        }
        
        // Retourne les activités avec leurs distances sous forme de réponse JSON
        return response()->json($activities);
    }

    /**
     * Calcule la distance orthodromique entre deux points géographiques en utilisant la formule de Haversine.
     *
     * @param float $userLat     Latitude de l'utilisateur.
     * @param float $userLon     Longitude de l'utilisateur.
     * @param float $activityLat Latitude de l'activité.
     * @param float $activityLon Longitude de l'activité.
     *
     * @return float Distance en kilomètres.
     */
    function distance($userLat, $userLon, $activityLat, $activityLon) 
    {
        $earthRadius = 6371; // Rayon moyen de la Terre en kilomètres
    
        // Conversion des degrés en radians
        $userLat = deg2rad($userLat);
        $userLon = deg2rad($userLon);
        $activityLat = deg2rad($activityLat);
        $activityLon = deg2rad($activityLon);
    
        // Calcul des différences de latitude et de longitude
        $deltaLat = $activityLat - $userLat;
        $deltaLon = $activityLon - $userLon;
    
        // Calcul de la distance orthodromique selon la formule de Haversine
        $a = sin($deltaLat/2) * sin($deltaLat/2) + cos($userLat) * cos($activityLat) * sin($deltaLon/2) * sin($deltaLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;
    
        return $distance;
    }

    /**
     * Affiche le détail d'une activité
     *
     * @param [type] $id
     * @return void
     */
    function show($id)
    {
        return Inertia::render('ActivityDetails',  ['activityId' =>$id]);
    }

    /**
     * Récupère toutes les catégories et affiche le formulaire d'ajout 
     *
     * @return void
     */
    function create ()
    {

        $categories = Category::all();
        return Inertia::render('AddActivity', ['categories' => $categories]);
    }


    /**
     * Stocke une nouvelle activité dans la base de données.
     *
     * @param Request $request Les données de la requête.
     *
     * @return RedirectResponse
     */
    function store(Request $request)
    {
        $userId = Auth::id();

        $client = new Client();

        $response = $client->get('https://geocode.maps.co/search?q={'.$request->street.' '.$request->house_number.' '.$request->zip_code.' '.$request->city.' '.$request->country.'}');

        $data = json_decode($response->getBody()->getContents());

        $activity = new Activity;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $activity->image = Storage::url($imagePath);
        }

        $activity->title = $request->title;
        $activity->category_id = $request->category_id;
        $activity->description = $request->description;
        $activity->user_id = $userId;
        $activity->street = $request->street;
        $activity->house_number = $request->house_number;
        $activity->zip_code = $request->zip_code;
        $activity->city = $request->city;
        $activity->country = $request->country;
        $activity->date = $request->date;
        $activity->image_path = $request->image;
        // $activity->image = $request->image;
        $activity->duration = $request->duration;
        $activity->nb_attendees = $request->nb_attendees;
        $activity->country = $request->country;
        $activity->lat = $data[0]->lat;
        $activity->lon = $data[0]->lon;


        // Sauvegarder les données dans la base de données
        $activity->save();

        return redirect('/dashboard')->with('success', 'Activité ajoutée avec succès');
    }

}
