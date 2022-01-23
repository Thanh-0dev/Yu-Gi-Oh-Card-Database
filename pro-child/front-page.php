<style><?php include "CSS/front-page-styles.css"?></style>

<img id="entry-banner" src="https://hh-test-3.fr/wp-content/uploads/2022/01/Banner.png" alt="Banner">

<?php get_header(); ?>

<div class="flex-column">
    <div class="flex-row banner">
        <div class="flex-column deck-builder">
            <h2>
                DECK BUILDER
            </h2>
            <p>Build your own Yu-Gi-Oh! decks using our online Yu-Gi-Oh! deck builder. Build, compare, filtre, share your deck or upload it to Yu Gi Oh Deck Builder!</p>
            <div class="white-button">
                <p>Coming soon</p>
            </div>
        </div>
    </div>
    <div class="flex-row row-2">
        <div class="cards">
            <div class="flex-column card">
                <img class="person" src="https://hh-test-3.fr/wp-content/uploads/2022/01/papi-yu-gi-yo.png" alt="Yugi's grandfather">
                <h2>RULES OF DUEL</h2>
                <p>You don't know the rules of Yu-Gi-Oh yet ? Download the rules from the link below and learn how to play like a true duelist !</p>
                <a href="https://hh-test-3.fr/rules/">
                    <div class="black-button">
                        <p>Read</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M6.69815 7.75732L5.28394 9.17154L12.355 16.2426L19.4261 9.17157L18.0118 7.75735L12.355 13.4142L6.69815 7.75732Z" fill="#6C757D"/>
                        </svg>
                    </div>
                </a>
            </div>
            <div class="flex-column card">
                <img class="person" src="https://hh-test-3.fr/wp-content/uploads/2022/01/gesse-yu-gi-yo.png" alt="Gesse">
                <img class="ygopro" src="https://hh-test-3.fr/wp-content/uploads/2022/01/logo-ygopro.png" alt="Logo YGoPro">
                <p>YgoPRO is the perfect platform to play Yu-Gi-OH! with players from around the world.</p>
                <a href="">
                    <div class="black-button">
                        <p>Download</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M6.69815 7.75732L5.28394 9.17154L12.355 16.2426L19.4261 9.17157L18.0118 7.75735L12.355 13.4142L6.69815 7.75732Z" fill="#6C757D"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="yu-newsletter">
        <div class="yu-left">
            <h2>GET NEWS & UPDATES</h2>
            <p>There are big things on the horizon. Don't miss upcoming events, product updates, and the latest Yu-Gi-Yo news!</p>
        </div>
        <div class="yu-right">
            <form action="email" class="yu-right-form1">
                <label for="yu-send-newsletter">Enter your email</label>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="26" viewBox="0 0 25 26" fill="none">
                    <path d="M10.3251 13H4.16681L2.10743 4.80733C2.09424 4.75972 2.08621 4.71083 2.08347 4.6615C2.06056 3.91046 2.88764 3.38962 3.60431 3.73337L22.9168 13L3.60431 22.2667C2.89597 22.6073 2.07931 22.1011 2.08347 21.3636C2.08558 21.2977 2.09716 21.2324 2.11785 21.1698L3.64597 16.125" stroke-width="2.08333" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </form>
            <form action="" class="yu-right-form2">
                <input type="checkbox"
                    name="checkbox"
                    id="checkbox"
                    value="checkbox">
                <label for="checkbox"></label>
                <div>YES! Konami may send me promotional emails and offers about Wizards' events, games, and services. By clicking “SEND” you agree to abide by our Terms and Conditions, Code of Conduct, and our Privacy Policy.</div>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>