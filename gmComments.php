<?php
header('Content-Type: application/json');

include "secret.php";

function getPlace($place_id, $key)
{
    $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$place_id&key=$key";
    $json = file_get_contents($url);
    return json_decode($json, true);
}

function getGMapsReviews($placeId, $apiKey)
{
    $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id=" . urlencode($placeId) . "&fields=reviews&key=" . urlencode($apiKey) . "&language=es";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && isset($data['result']['reviews'])) {
        $comentariosFiltrados = array_filter($data['result']['reviews'], function ($review) {
            return $review['rating'] > 3;
        });

        $comentariosFiltrados = array_slice($comentariosFiltrados, 0, 5);

        if (!empty($comentariosFiltrados)) {
            // echo '<div id="gmComments"><ul>';
            // foreach ($comentariosFiltrados as $comentario) {
            //     echo '<li>              
            //     <p class="text-gray-500 dark:text-gray-400 mb-4">Puntuación: ' . htmlspecialchars($comentario['rating']) . '/5</p>
            //     <p class="text-gray-500 dark:text-gray-400">' . htmlspecialchars($comentario['text']) . '</p>
            //     <hr class="my-4 border-purple-500/50">
            //     <div class="flex items-center gap-x-2 text-gray-500 dark:text-gray-400">
            //     <img src="' . htmlspecialchars($comentario['profile_photo_url']) . '" alt="Foto de perfil" width="50" height="50">
            //     <span class="text-sm">
            //     <h3>' . htmlspecialchars($comentario['author_name']) . '</h3>
            //     </span>
            //     </div>
            //     </li>';
            // }
            // echo '</ul></div>';

            // Return JSON response
            echo json_encode($comentariosFiltrados, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            return;
        } else {

            return json_encode(array('error' => 'No se encontraron comentarios con más de 3 estrellas.'));
            // echo '<p id="gmComments">No se encontraron comentarios con más de 3 estrellas.</p>';
        }
    } else {
        return json_encode(array('error' => 'No se pudieron obtener los comentarios.'));
        // lo de abajo no se ejecuta porque ya volvió con el return de arriba
        echo '<p id="contenedor-comentarios">No se pudieron obtener los comentarios.</p>';
        if (isset($data['error_message'])) {
            echo '<p>Error de la API: ' . htmlspecialchars($data['error_message']) . '</p>';
        }
    }
}

getGMapsReviews($place_id, $key);
