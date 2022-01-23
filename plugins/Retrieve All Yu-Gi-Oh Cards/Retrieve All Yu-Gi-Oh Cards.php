<?php

/* 
* Plugin Name: Retrieve All Yu-Gi-Oh Cards
* Description: Activate to retrieve the Yu-Gi-Oh Cards from the API (<a href="https://db.ygoprodeck.com/api-guide/">https://db.ygoprodeck.com/api-guide/</a>) and insert the cards as post with taxonomies and custom fields.
* Version: 1.0.0
* Author: <a href="https://www.linkedin.com/in/thanh-long-pham-9942111b9/">Thanh-Long PHAM</a>, <a href="https://www.linkedin.com/in/louis-leveneur-74410b1b9/">Louis LEVENEUR</a>
*/

function RetrieveAllYuGiOhCards(){
    /* Retrieve the string with all the cards from the API */
    $results = file_get_contents('https://db.ygoprodeck.com/api/v8/cardinfo.php');
 
    /* Decode the string to a json */
    $json = json_decode($results);

    /* Get only the data */
    $data = $json->data;

    rsort($data);
 
    foreach( $data as $card ){
        /* Don't insert the card if it is already in the database */
        if (post_exists($card->name)){
            continue;
        };

        /* Create a card slug */
        $card_slug = ($card->name . '_' . $card->id);

        /* Take the image's URL from the card */
        $card_images = $card->card_images[0];
        $card_url = $card_images->image_url;

        /* Insert a card as a post */
        $inserted_card = wp_insert_post( [
            'post_name' => $card_slug,
            'post_title' => $card->name,
            'post_type' => 'card',
            'post_status' => 'publish',
        ] );
        
        /* Insert the taxonomies to the post with the card's value*/
        if ($card->type){
            wp_set_object_terms($inserted_card, $card->type, 'card_type');
        }
        if ($card->race){
            wp_set_object_terms($inserted_card, $card->race, 'race');
        }
        if ($card->level){
            wp_set_object_terms($inserted_card, strval($card->level), 'level');
        }
        if ($card->attribute){
            wp_set_object_terms($inserted_card, $card->attribute, 'attribute');
        }
        if (strpos($card->type, 'Link') !== false){
            wp_set_object_terms($inserted_card, strval($card->linkval), 'link');
        }
        if (strpos($card->type, 'Pendulum') !== false){
            wp_set_object_terms($inserted_card, strval($card->scale), 'scale');
        }

        /* Prepare the ACF with the card's value */
        $fillable = [
            'field_61e1a5bed7360' => $card->id,
            'field_61e1a7e6d7361' => $card->name,
            'field_61e1a80dd7363' => $card->desc,
            'field_61e1a825d7364' => $card->atk,
            'field_61e1a862d7365' => $card->def,
            'field_61e1a894d7369' => $card_url,
        ];

        /* Update the ACF values */
        foreach( $fillable as $key => $name ) {
            update_field( $key, $name, $inserted_card );
        };
    };
};
register_activation_hook(__FILE__, 'RetrieveAllYuGiOhCards');