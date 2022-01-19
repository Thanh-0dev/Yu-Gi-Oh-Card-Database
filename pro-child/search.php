<?php get_header(); ?>

<style><?php include "CSS/archive-card-styles.css"?></style>

<?php 

$type_filter = [];
$attribute_filter = [];
$level_filter = [];
$race_filter = [];
$scale_filter = [];

foreach (get_terms("card_type") as $type) {
    array_push($type_filter, $type->name);
}

foreach (get_terms("attribute") as $attribute) {
    array_push($attribute_filter, $attribute->name);
}

foreach (get_terms("level") as $level) {
    array_push($level_filter, $level->name);
}

foreach (get_terms("race") as $race) {
    array_push($race_filter, $race->name);
}

foreach (get_terms("scale") as $scale) {
    array_push($scale_filter, $scale->name);
}

if (!$_GET["type"] AND !$_GET["attribute"] AND !$_GET["level"] AND !$_GET["race"] AND !$_GET["scale"]) {
    $args =  [
        "post_type" => "card",
        "posts_per_page" => 98,
        "s" => $_GET["s"] ?? null,
        "orderby" => "asc",
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    ];
} else {
    if ($_GET["race"] AND in_array($_GET["race"][0], ["Continuous", "Equip", "Field", "Normal", "Quick-Play", "Ritual"]) OR ($_GET["type"] AND in_array($_GET["type"][0], ["Skill Card", "Spell Card", "Trap Card"]))) {
        $args =  [
            "post_type" => "card",
            "posts_per_page" => 98,
            "s" => $_GET["s"] ?? null,
            "orderby" => "asc",
            "tax_query" => [
                [
                    "relation" => "AND",
                    [
                        "taxonomy" => "card_type",
                        "field" => "slug",
                        "terms" => $_GET["type"] ?? $type_filter
                    ],
                ],
                [
                    "relation" => "AND",
                    [
                        "taxonomy" => "race",
                    "field" => "slug",
                    "terms" => $_GET["race"] ?? $race_filter
                    ],
                ]
            ],
        ];
    } else {
        if ($_GET["type"][0] === "Link Monster") {
            $args =  [
                "post_type" => "card",
                "posts_per_page" => 98,
                "s" => $_GET["s"] ?? null,
                "orderby" => "asc",
                "tax_query" => [
                    [
                        "relation" => "AND",
                        ["taxonomy" => "card_type",
                        "field" => "slug",
                        "terms" => $_GET["type"] ?? $type_filter],
                    ],
                    [
                        "relation" => "AND",
                        ["taxonomy" => "race",
                        "field" => "slug",
                        "terms" => $_GET["race"] ?? $race_filter],
                    ],
                    [
                        "relation" => "AND",
                        ["taxonomy" => "attribute",
                        "field" => "slug",
                        "terms" => $_GET["attribute"] ?? $attribute_filter],
                    ]
                ],
            ];
        } else {
            if ($_GET["scale"]){
                $args =  [
                    "post_type" => "card",
                    "posts_per_page" => 98,
                    "s" => $_GET["s"] ?? null,
                    "orderby" => "asc",
                    "tax_query" => [
                        [
                            "taxonomy" => "card_type",
                            "field" => "slug",
                            "terms" => $_GET["type"] ?? $type_filter,
                        ],
                        [
                            "relation" => "AND",
                            ["taxonomy" => "attribute",
                            "field" => "slug",
                            "terms" => $_GET["attribute"] ?? $attribute_filter],
                        ],
                        [
                            "relation" => "AND",
                            ["taxonomy" => "level",
                            "field" => "slug",
                            "terms" => $_GET["level"] ?? $level_filter],
                        ],
                        [
                            "relation" => "AND",
                            ["taxonomy" => "race",
                            "field" => "slug",
                            "terms" => $_GET["race"] ?? $race_filter],
                        ],
                        [
                            "relation" => "AND",
                            ["taxonomy" => "scale",
                            "field" => "slug",
                            "terms" => $_GET["scale"] ?? $scale_filter],
                        ]
                    ],
                ];
            } else {
                $args =  [
                    "post_type" => "card",
                    "posts_per_page" => 98,
                    "s" => $_GET["s"] ?? null,
                    "orderby" => "asc",
                    "tax_query" => [
                        [
                            "taxonomy" => "card_type",
                            "field" => "slug",
                            "terms" => $_GET["type"] ?? $type_filter,
                        ],
                        [
                            "relation" => "AND",
                            ["taxonomy" => "attribute",
                            "field" => "slug",
                            "terms" => $_GET["attribute"] ?? $attribute_filter],
                        ],
                        [
                            "relation" => "AND",
                            ["taxonomy" => "level",
                            "field" => "slug",
                            "terms" => $_GET["level"] ?? $level_filter],
                        ],
                        [
                            "relation" => "AND",
                            ["taxonomy" => "race",
                            "field" => "slug",
                            "terms" => $_GET["race"] ?? $race_filter],
                        ]
                    ],
                ];
            }
        }
    }
}
 ?>


<?php $query = new WP_Query($args);?>

    <!-- CONTAINER CARDS -->
    <div class="yu-container-cards">

        <!-- FILTER -->
        <div class="yu-container-filter">

            <!-- COLUM 1 -->
            <div class="yu-container-filter-col1">

                <!-- FILTER VIEW -->
                <div class="yu-select-view-btn">
                    <button class="yu-checkbox-view-btn active" id="list-button" onclick="update_view(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
                            <path d="M22.2656 4.6875H8.00781C7.90039 4.6875 7.8125 4.77539 7.8125 4.88281V6.25C7.8125 6.35742 7.90039 6.44531 8.00781 6.44531H22.2656C22.373 6.44531 22.4609 6.35742 22.4609 6.25V4.88281C22.4609 4.77539 22.373 4.6875 22.2656 4.6875ZM22.2656 11.6211H8.00781C7.90039 11.6211 7.8125 11.709 7.8125 11.8164V13.1836C7.8125 13.291 7.90039 13.3789 8.00781 13.3789H22.2656C22.373 13.3789 22.4609 13.291 22.4609 13.1836V11.8164C22.4609 11.709 22.373 11.6211 22.2656 11.6211ZM22.2656 18.5547H8.00781C7.90039 18.5547 7.8125 18.6426 7.8125 18.75V20.1172C7.8125 20.2246 7.90039 20.3125 8.00781 20.3125H22.2656C22.373 20.3125 22.4609 20.2246 22.4609 20.1172V18.75C22.4609 18.6426 22.373 18.5547 22.2656 18.5547ZM2.53906 5.56641C2.53906 5.74595 2.57443 5.92373 2.64313 6.08961C2.71184 6.25548 2.81255 6.4062 2.9395 6.53315C3.06646 6.66011 3.21718 6.76081 3.38305 6.82952C3.54892 6.89823 3.72671 6.93359 3.90625 6.93359C4.08579 6.93359 4.26358 6.89823 4.42945 6.82952C4.59532 6.76081 4.74604 6.66011 4.873 6.53315C4.99995 6.4062 5.10066 6.25548 5.16937 6.08961C5.23807 5.92373 5.27344 5.74595 5.27344 5.56641C5.27344 5.38686 5.23807 5.20908 5.16937 5.04321C5.10066 4.87733 4.99995 4.72661 4.873 4.59966C4.74604 4.4727 4.59532 4.372 4.42945 4.30329C4.26358 4.23458 4.08579 4.19922 3.90625 4.19922C3.72671 4.19922 3.54892 4.23458 3.38305 4.30329C3.21718 4.372 3.06646 4.4727 2.9395 4.59966C2.81255 4.72661 2.71184 4.87733 2.64313 5.04321C2.57443 5.20908 2.53906 5.38686 2.53906 5.56641V5.56641ZM2.53906 12.5C2.53906 12.6795 2.57443 12.8573 2.64313 13.0232C2.71184 13.1891 2.81255 13.3398 2.9395 13.4667C3.06646 13.5937 3.21718 13.6944 3.38305 13.7631C3.54892 13.8318 3.72671 13.8672 3.90625 13.8672C4.08579 13.8672 4.26358 13.8318 4.42945 13.7631C4.59532 13.6944 4.74604 13.5937 4.873 13.4667C4.99995 13.3398 5.10066 13.1891 5.16937 13.0232C5.23807 12.8573 5.27344 12.6795 5.27344 12.5C5.27344 12.3205 5.23807 12.1427 5.16937 11.9768C5.10066 11.8109 4.99995 11.6602 4.873 11.5333C4.74604 11.4063 4.59532 11.3056 4.42945 11.2369C4.26358 11.1682 4.08579 11.1328 3.90625 11.1328C3.72671 11.1328 3.54892 11.1682 3.38305 11.2369C3.21718 11.3056 3.06646 11.4063 2.9395 11.5333C2.81255 11.6602 2.71184 11.8109 2.64313 11.9768C2.57443 12.1427 2.53906 12.3205 2.53906 12.5V12.5ZM2.53906 19.4336C2.53906 19.6131 2.57443 19.7909 2.64313 19.9568C2.71184 20.1227 2.81255 20.2734 2.9395 20.4003C3.06646 20.5273 3.21718 20.628 3.38305 20.6967C3.54892 20.7654 3.72671 20.8008 3.90625 20.8008C4.08579 20.8008 4.26358 20.7654 4.42945 20.6967C4.59532 20.628 4.74604 20.5273 4.873 20.4003C4.99995 20.2734 5.10066 20.1227 5.16937 19.9568C5.23807 19.7909 5.27344 19.6131 5.27344 19.4336C5.27344 19.2541 5.23807 19.0763 5.16937 18.9104C5.10066 18.7445 4.99995 18.5938 4.873 18.4668C4.74604 18.3399 4.59532 18.2392 4.42945 18.1705C4.26358 18.1018 4.08579 18.0664 3.90625 18.0664C3.72671 18.0664 3.54892 18.1018 3.38305 18.1705C3.21718 18.2392 3.06646 18.3399 2.9395 18.4668C2.81255 18.5938 2.71184 18.7445 2.64313 18.9104C2.57443 19.0763 2.53906 19.2541 2.53906 19.4336V19.4336Z"/>
                        </svg>
                        List
                    </button>
                    <button class="yu-checkbox-view-btn" id="grid-button" onclick="update_view(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
                            <path d="M5.20833 7.29167C5.76087 7.29167 6.29077 7.07217 6.68147 6.68147C7.07217 6.29077 7.29167 5.76087 7.29167 5.20833C7.29167 4.6558 7.07217 4.12589 6.68147 3.73519C6.29077 3.34449 5.76087 3.125 5.20833 3.125C4.6558 3.125 4.12589 3.34449 3.73519 3.73519C3.34449 4.12589 3.125 4.6558 3.125 5.20833C3.125 5.76087 3.34449 6.29077 3.73519 6.68147C4.12589 7.07217 4.6558 7.29167 5.20833 7.29167V7.29167ZM12.5 7.29167C13.0525 7.29167 13.5824 7.07217 13.9731 6.68147C14.3638 6.29077 14.5833 5.76087 14.5833 5.20833C14.5833 4.6558 14.3638 4.12589 13.9731 3.73519C13.5824 3.34449 13.0525 3.125 12.5 3.125C11.9475 3.125 11.4176 3.34449 11.0269 3.73519C10.6362 4.12589 10.4167 4.6558 10.4167 5.20833C10.4167 5.76087 10.6362 6.29077 11.0269 6.68147C11.4176 7.07217 11.9475 7.29167 12.5 7.29167ZM19.7917 7.29167C20.3442 7.29167 20.8741 7.07217 21.2648 6.68147C21.6555 6.29077 21.875 5.76087 21.875 5.20833C21.875 4.6558 21.6555 4.12589 21.2648 3.73519C20.8741 3.34449 20.3442 3.125 19.7917 3.125C19.2391 3.125 18.7092 3.34449 18.3185 3.73519C17.9278 4.12589 17.7083 4.6558 17.7083 5.20833C17.7083 5.76087 17.9278 6.29077 18.3185 6.68147C18.7092 7.07217 19.2391 7.29167 19.7917 7.29167V7.29167ZM5.20833 14.5833C5.76087 14.5833 6.29077 14.3638 6.68147 13.9731C7.07217 13.5824 7.29167 13.0525 7.29167 12.5C7.29167 11.9475 7.07217 11.4176 6.68147 11.0269C6.29077 10.6362 5.76087 10.4167 5.20833 10.4167C4.6558 10.4167 4.12589 10.6362 3.73519 11.0269C3.34449 11.4176 3.125 11.9475 3.125 12.5C3.125 13.0525 3.34449 13.5824 3.73519 13.9731C4.12589 14.3638 4.6558 14.5833 5.20833 14.5833V14.5833ZM12.5 14.5833C13.0525 14.5833 13.5824 14.3638 13.9731 13.9731C14.3638 13.5824 14.5833 13.0525 14.5833 12.5C14.5833 11.9475 14.3638 11.4176 13.9731 11.0269C13.5824 10.6362 13.0525 10.4167 12.5 10.4167C11.9475 10.4167 11.4176 10.6362 11.0269 11.0269C10.6362 11.4176 10.4167 11.9475 10.4167 12.5C10.4167 13.0525 10.6362 13.5824 11.0269 13.9731C11.4176 14.3638 11.9475 14.5833 12.5 14.5833ZM19.7917 14.5833C20.3442 14.5833 20.8741 14.3638 21.2648 13.9731C21.6555 13.5824 21.875 13.0525 21.875 12.5C21.875 11.9475 21.6555 11.4176 21.2648 11.0269C20.8741 10.6362 20.3442 10.4167 19.7917 10.4167C19.2391 10.4167 18.7092 10.6362 18.3185 11.0269C17.9278 11.4176 17.7083 11.9475 17.7083 12.5C17.7083 13.0525 17.9278 13.5824 18.3185 13.9731C18.7092 14.3638 19.2391 14.5833 19.7917 14.5833V14.5833ZM5.20833 21.875C5.76087 21.875 6.29077 21.6555 6.68147 21.2648C7.07217 20.8741 7.29167 20.3442 7.29167 19.7917C7.29167 19.2391 7.07217 18.7092 6.68147 18.3185C6.29077 17.9278 5.76087 17.7083 5.20833 17.7083C4.6558 17.7083 4.12589 17.9278 3.73519 18.3185C3.34449 18.7092 3.125 19.2391 3.125 19.7917C3.125 20.3442 3.34449 20.8741 3.73519 21.2648C4.12589 21.6555 4.6558 21.875 5.20833 21.875V21.875ZM12.5 21.875C13.0525 21.875 13.5824 21.6555 13.9731 21.2648C14.3638 20.8741 14.5833 20.3442 14.5833 19.7917C14.5833 19.2391 14.3638 18.7092 13.9731 18.3185C13.5824 17.9278 13.0525 17.7083 12.5 17.7083C11.9475 17.7083 11.4176 17.9278 11.0269 18.3185C10.6362 18.7092 10.4167 19.2391 10.4167 19.7917C10.4167 20.3442 10.6362 20.8741 11.0269 21.2648C11.4176 21.6555 11.9475 21.875 12.5 21.875ZM19.7917 21.875C20.3442 21.875 20.8741 21.6555 21.2648 21.2648C21.6555 20.8741 21.875 20.3442 21.875 19.7917C21.875 19.2391 21.6555 18.7092 21.2648 18.3185C20.8741 17.9278 20.3442 17.7083 19.7917 17.7083C19.2391 17.7083 18.7092 17.9278 18.3185 18.3185C17.9278 18.7092 17.7083 19.2391 17.7083 19.7917C17.7083 20.3442 17.9278 20.8741 18.3185 21.2648C18.7092 21.6555 19.2391 21.875 19.7917 21.875V21.875Z"/>
                        </svg>
                        Grid
                    </button>
                </div>

            </div>

            <!-- COLUM 2 -->
            <div class="yu-container-filter-col2">

                <!-- ROW 1 -->
                <form class="yu-container-filter-row1" action="" method="get">
                    <div class="flex-1">

                        <!-- ATTRIBUTE -->
                        <div class="yu-select-filter" id="yu-filter-attribute">

                            <button type="button" class="yu-select-filter-btn-attribute" id="attribute-filter" onclick="openFilterOnClick(this)">

                                <div>Attribute</div>
                                <svg id="attribute-svg" class="drop-up"  xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path d="M6.69815 7.75732L5.28394 9.17154L12.355 16.2426L19.4261 9.17157L18.0118 7.75735L12.355 13.4142L6.69815 7.75732Z" fill="#6C757D"/>
                                </svg>

                            </button>

                            <div class="yu-select-filter-toogle-attribute" id="attribute-form">

                                <?php
                                    $terms_attributes = get_terms([
                                        'taxonomy' => 'attribute',
                                        'hide_empty' => false
                                    ]);
                                    foreach ($terms_attributes as $term_attribute) :
                                ?>
                                    <div class="yu-select-filter-row-attribute">
                                        <div class="yu-select-filter-checkbox-text">
                                            <div class="yu-select-filter-checkbox">

                                                <input
                                                    type="radio"
                                                    name="attribute[]"
                                                    id="checkbox_<?php echo $term_attribute->name; ?>"
                                                    value="<?php echo $term_attribute->name; ?>"
                                                />

                                                <label for="checkbox_<?php echo $term_attribute->name; ?>"></label>

                                            </div>
                                            <p><?php echo $term_attribute->name; ?></p>
                                        </div>

                                        <div class="yu-select-filter-term-attribute">
                                            <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/<?= strtoupper($term_attribute->name) ?>.png" alt="<?= strtoupper($term_attribute->name) ?>">
                                        </div>

                                    </div>
                                <?php endforeach; ?>

                            </div>
                            </div>

                            <!-- LEVEL -->
                            <div class="yu-select-filter" id="yu-filter-level">

                            <button type="button" class="yu-select-filter-btn-level" id="level-filter" onclick="openFilterOnClick(this)">

                                <div>Level</div>
                                <svg id="level-svg" class="drop-up"  xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path d="M6.69815 7.75732L5.28394 9.17154L12.355 16.2426L19.4261 9.17157L18.0118 7.75735L12.355 13.4142L6.69815 7.75732Z" fill="#6C757D"/>
                                </svg>

                            </button>

                            <div class="yu-select-filter-toogle-level" id="level-form">

                                    <div class="yu-select-filter-row">
                                        <div class="yu-container-select-filter-checkbox">

                                            <!-- LEVEL -->
                                            <div class="yu-select-filter-checkbox-level">
                                                <div class="yu-select-filter-checkbox-title">
                                                    <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-level.png" alt="Level">
                                                    <p>Level</p>
                                                </div>
                                                <div class="yu-select-filter-checkbox-list-level">
                                                    <?php 
                                                        $terms_level = get_terms("level");
                                                        sort($terms_level);
                                                        foreach ($terms_level as $term_level) :
                                                    ?>
                                                        
                                                        <div class="yu-select-filter-checkbox-level">
                                                            <div class="flex-row">
                                                                <div class="yu-select-filter-checkbox">

                                                                    <input
                                                                        type="radio"
                                                                        name="level[]"
                                                                        id="checkbox_level_<?php echo $term_level->name; ?>"
                                                                        value="<?php echo $term_level->name; ?>"
                                                                    />

                                                                    <label for="checkbox_level_<?php echo $term_level->name; ?>"></label>

                                                                </div>
                                                                <p><?php echo $term_level->name; ?></p>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                
                                                </div>
                                            </div>

                                            <!-- Pendule -->
                                            <div class="yu-select-filter-checkbox-pandule">
                                                <div class="yu-select-filter-checkbox-title">
                                                    <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-pendule.png" alt="Pendulum Card">
                                                    <p>Pendulum</p>
                                                </div>
                                                <div class="yu-select-filter-checkbox-list-pandule">
                                                    <?php 
                                                        $terms_pendule = get_terms("scale");
                                                        sort($terms_pendule);
                                                        foreach ($terms_pendule as $term_pendule) :
                                                            
                                                    ?>
                                                        
                                                        <div class="yu-select-filter-checkbox-pendule">
                                                            <div class="flex-row">
                                                                <div class="yu-select-filter-checkbox">

                                                                    <input
                                                                        type="radio"
                                                                        name="scale[]"
                                                                        id="checkbox_pendule_<?php echo $term_pendule->name; ?>"
                                                                        value="<?php echo $term_pendule->name; ?>"
                                                                    />

                                                                    <label for="checkbox_pendule_<?php echo $term_pendule->name; ?>"></label>

                                                                </div>
                                                                <p><?php echo $term_pendule->name; ?></p>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex-2">
                        <!-- RACE -->
                        <div class="yu-select-filter" id="yu-filter-race">

                            <button type="button" class="yu-select-filter-btn-race" id="race-filter" onclick="openFilterOnClick(this)">

                                <div>Race</div>
                                <svg id="race-svg" class="drop-up"  xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path d="M6.69815 7.75732L5.28394 9.17154L12.355 16.2426L19.4261 9.17157L18.0118 7.75735L12.355 13.4142L6.69815 7.75732Z" fill="#6C757D"/>
                                </svg>

                            </button>

                            <div class="yu-select-filter-toogle-race" id="race-form">

                                <div class="yu-select-filter-row">
                                    <div class="yu-container-select-filter-checkbox">

                                        <!-- MONSTRE -->
                                        <div class="yu-select-filter-checkbox-race">
                                            <div class="yu-select-filter-checkbox-title">
                                                <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-monster-card.png" alt="Monster">
                                                <p>Monster</p>
                                            </div>
                                            <div class="yu-select-filter-checkbox-list-race">
                                                <?php 
                                                    $terms_races = get_terms("race");
                                                    foreach( $terms_races as $term_race ) :
                                                        if ($term_race->count < 10 OR in_array($term_race->name, ["Normal", "Continuous", "Counter", "Field", "Quick-Play", "Equip"])){
                                                            continue;
                                                        };
                                                        $term_race->name = str_replace(" ", "-", $term_race->name);
                                                ?>
                                                    <div class="flex-row">
                                                        <?php if ($term_race->name !== 'Normal' || $term_race->name !== 'Field' || $term_race->name !== 'Equip' || $term_race->name !== 'Continuous' || $term_race->name !== 'Quick-Play' || $term_race->name !== 'Ritual'|| $term_race->name !== 'Counter') : ?>
                                                            <div class="yu-select-filter-checkbox">

                                                                <input
                                                                    type="radio"
                                                                    name="race[]"
                                                                    id="checkbox_<?php echo $term_race->name; ?>"
                                                                    value="<?php echo $term_race->name; ?>"
                                                                />

                                                                <label for="checkbox_<?php echo $term_race->name; ?>"></label>

                                                            </div>
                                                            <p><?php echo $term_race->name; ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                                
                                            </div>
                                        </div>

                                        <!-- SPELL -->
                                        <div class="yu-select-filter-checkbox-race">
                                            <div class="yu-select-filter-checkbox-title">
                                                <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-spell-card.png" alt="Spell Card">
                                                <p>Spell Card</p>
                                            </div>
                                            <div class="yu-select-filter-checkbox-list-race-spell">
                                                
                                                <?php 
                                                    $terms_races = get_terms('race',);
                                                    foreach ($terms_races as $term_race) :
                                                ?>
                                                    
                                                    <div class="yu-select-filter-checkbox-race">
                                                        <div class="flex-row">
                                                            <?php if ($term_race->name == 'Normal' || $term_race->name == 'Field' || $term_race->name == 'Equip' || $term_race->name == 'Continuous' || $term_race->name == 'Quick-Play' || $term_race->name == 'Ritual') : ?>
                                                                <div class="yu-select-filter-checkbox">

                                                                    <input
                                                                        type="radio"
                                                                        name="race[]"
                                                                        id="checkbox_spell_<?php echo $term_race->name; ?>"
                                                                        value="<?php echo $term_race->name; ?>"
                                                                    />

                                                                    <label for="checkbox_spell_<?php echo $term_race->name; ?>"></label>

                                                                </div>
                                                                <p><?php echo $term_race->name; ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                
                                            </div>
                                        </div>

                                        <!-- TRAP -->
                                        <div class="yu-select-filter-checkbox-race">
                                            <div class="yu-select-filter-checkbox-title">
                                                <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-trap-card.png" alt="Trap Card">
                                                <p>Trap Card</p>
                                            </div>
                                            <div class="yu-select-filter-checkbox-list-race-spell">
                                                
                                                <?php 
                                                    $terms_races = get_terms([
                                                        'taxonomy' => 'race',
                                                        'hide_empty' => false
                                                    ]);
                                                    foreach ($terms_races as $term_race) :
                                                ?>
                                                    
                                                    <div class="yu-select-filter-checkbox-race">
                                                        <div class="flex-row">
                                                        <?php if ($term_race->name == 'Normal' || $term_race->name == 'Continuous' || $term_race->name == 'Counter') : ?>
                                                                <div class="yu-select-filter-checkbox">

                                                                    <input
                                                                        type="radio"
                                                                        name="race[]"
                                                                        id="checkbox_trap_<?php echo $term_race->name; ?>"
                                                                        value="<?php echo $term_race->name; ?>"
                                                                    />

                                                                    <label for="checkbox_trap_<?php echo $term_race->name; ?>"></label>

                                                                </div>
                                                                <p><?php echo $term_race->name; ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            </div>

                            <!-- TYPE -->
                            <div class="yu-select-filter" id="yu-filter-type">

                            <button type="button" class="yu-select-filter-btn-type" id="type-filter" onclick="openFilterOnClick(this)">

                                <div>Type</div>
                                <svg id="type-svg" class="drop-up" xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                    <path d="M6.69815 7.75732L5.28394 9.17154L12.355 16.2426L19.4261 9.17157L18.0118 7.75735L12.355 13.4142L6.69815 7.75732Z" fill="#6C757D"/>
                                </svg>

                            </button>

                            <div class="yu-select-filter-toogle-type" id="type-form">

                                <div class="yu-select-filter-row">
                                    <div class="yu-container-select-filter-checkbox">

                                        <!-- MAIN DECK -->
                                        <div class="yu-select-filter-checkbox-type">
                                            <div class="yu-select-filter-checkbox-title">
                                                <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-monster-card.png" alt="Main deck">
                                                <p>Main Deck Types</p>
                                            </div>
                                            <div class="yu-select-filter-checkbox-list-type">
                                                
                                                <?php 
                                                    $terms_type = get_terms("card_type");
                                                    sort($terms_type);
                                                    foreach ($terms_type as $term_type) :
                                                        if (in_array($term_type->name, ["Link Monster", "Pendulum Effect Fusion Monster", "Synchro Monster", "Synchro Pendulum Effect Monster", "Synchro Tuner Monster", "XYZ Monster", "XYZ Pendulum Effect Monster"])){
                                                            continue;
                                                        }
                                                ?>
                                                    
                                                    <div class="yu-select-filter-checkbox-type">
                                                        <div class="flex-row">
                                                            <div class="yu-select-filter-checkbox">

                                                                <input
                                                                    type="radio"
                                                                    name="type[]"
                                                                    id="checkbox_<?php echo $term_type->name; ?>"
                                                                    value="<?php echo $term_type->name; ?>"
                                                                />

                                                                <label for="checkbox_<?php echo $term_type->name; ?>"></label>

                                                            </div>
                                                            <p><?php echo $term_type->name; ?></p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                
                                            </div>
                                        </div>

                                        <!-- EXTRA DECK -->
                                        <div class="yu-select-filter-checkbox-type">
                                            <div class="yu-select-filter-checkbox-title">
                                                <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-trap-card.png" alt="Extra deck">
                                                <p>Extra Deck Types</p>
                                            </div>
                                            <div class="yu-select-filter-checkbox-list-type-spell">
                                                
                                                <?php 
                                                    $terms_type = get_terms([
                                                        'taxonomy' => 'card_type',
                                                        'hide_empty' => false
                                                    ]);
                                                    foreach ($terms_type as $term_type) :
                                                ?>
                                                    
                                                    <div class="yu-select-filter-checkbox-type">
                                                        <div class="flex-row">
                                                            <?php if ($term_type->name == 'Link Monster' || $term_type->name == 'Pendulum Effect Fusion Monster' || $term_type->name == 'Synchro Monster' || $term_type->name == 'Synchro Pendulum Effect Monster' || $term_type->name == 'Synchro Tuner Monster' || $term_type->name == 'XYZ Monster' || $term_type->name == 'XYZ Pendulum Effect Monster') : ?>
                                                                <div class="yu-select-filter-checkbox">

                                                                    <input
                                                                        type="radio"
                                                                        name="type[]"
                                                                        id="checkbox_<?php echo $term_type->name; ?>"
                                                                        value="<?php echo $term_type->name; ?>"
                                                                    />

                                                                    <label for="checkbox_<?php echo $term_type->name; ?>"></label>

                                                                </div>
                                                                <p><?php echo $term_type->name; ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <button type="submit" class="yu-select-filter-btn-submit" id="submit-filter">
                            <p>Filter</p>
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <div class="pagination">
            <?php 
            echo paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $query->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'prev_next'    => true,
                'prev_text'    => "Previous",
                'next_text'    => "Next",
                'add_args'     => false,
                'add_fragment' => '',
            ) );
            ?>
        </div>

        <!-- ALL CARDS -->
        <div class="yu-container-all-cards">

                <!-- LIST -->
                <div id="yu-list-card">
                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) : ?>
                            <?php $query->the_post();
                                $attribute = get_the_terms(get_the_ID(), "attribute")[0];
                                $level = get_the_terms(get_the_ID(), "level")[0];
                                $race = get_the_terms(get_the_ID(), "race")[0];
                                $card_type = get_the_terms(get_the_ID(), "card_type")[0];
                                $link = get_the_terms(get_the_ID(), "link")[0];?>

                            <div class="yu-list-card">
                                <div class="yu-list-img-card">
                                    <img src="<?php the_field("image_url") ?>" alt="<?php the_title() ?> - <?php the_field("id") ?>" />
                                </div>
                                <div class="yu-description-card">
                                    <div class="yu-description-card-row1">
                                        <div class="yu-description-card-header">
                                            <h2><?php the_title() ?></h2>

                                            <?php if (strpos($card_type->name, 'Monster') !== false) :?>
                                                <img class="yu-card-img" src="https://hh-test-3.fr/wp-content/uploads/2022/01/<?= strtoupper($attribute->name) ?>.png" alt="<?= strtoupper($attribute->name) ?>">
                                            <?php endif; ?>

                                            <?php if ($card_type->name == 'Spell Card' || $card_type->name == 'Trap Card') :?>
                                                <div class="yu-card-type-spell-trap">
                                                    <?php if ($card_type->name == 'Spell Card') :?>
                                                        <img class="yu-card-img" src="https://hh-test-3.fr/wp-content/uploads/2022/01/SPELL.png" alt="SPELL">
                                                    <?php endif; ?>
                                                    <?php if ($card_type->name == 'Trap Card') :?>
                                                        <img class="yu-card-img" src="https://hh-test-3.fr/wp-content/uploads/2022/01/TRAP.png" alt="TRAP">
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="yu-card-type-level">
                                            <div class="yu-card-type">
                                                <p><?= $card_type->name .' | ' . $race->name; ?></p>
                                            </div>

                                            <?php if ($level->name == true) :?>
                                                <div class="yu-card-level">

                                                    <?php $level_card = intval($level->name); ?>
                                                    <?php while ($level_card !== 0 ) : $level_card = $level_card-1;?>
                                                        <img src="https://hh-test-3.fr/wp-content/uploads/2022/01/icon-level.png" alt="icon-level" >
                                                    <?php endwhile; ?>
                                                    <p>(<?= $level->name; "étoile"?>)</p>

                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <p><?php the_field("desc") ?></p>
                                    </div>
                                    <div class="yu-description-card-row2">
                                        <?php if (strpos($card_type->name, 'Monster') !== false) :?>
                                            <div class="yu-card-atk-def">
                                                <p>
                                                    ATK : <?php the_field("atk")?> / 
                                                    <?php if ($level->name == true) : ?>
                                                        DEF : <?php the_field("def") ?>
                                                    <?php endif; ?>
                                                    <?php if ($link->name == true) : ?>
                                                        LINK-<?php echo($link->name) ?>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

                <!-- GALLERY -->
                <div id="yu-gallery-card">
                    <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : ?>
                                <?php $query->the_post(); ?>

                                <div class="yu-gallery-card">
                                    <div class="yu-gallery-img-card">
                                        <img src="<?php the_field("image_url") ?>" alt="<?php the_title() ?> - <?php the_field("id") ?>" />
                                    </div>
                                </div>

                            <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            
        </div>

        <div class="pagination">
            <?php 
            echo paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $query->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'prev_next'    => true,
                'prev_text'    => "Previous",
                'next_text'    => "Next",
                'add_args'     => false,
                'add_fragment' => '',
            ) );
            ?>
        </div>

    </div>

<?php wp_reset_postdata() ?>

<script><?php include "JS/archive-card-script.js"?></script>

<?php get_footer(); ?>