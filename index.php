<!DOCTYPE html>
<html>
<head>
    <title>UTEP CS DEPT Asset Rental</title>

    <!--  Stylesheets  -->
    <link rel="stylesheet" href="css/standard.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Used for multi-select dropdown menu -->
    <script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

    <!--  Javascript APIs from CDN  -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
</head>

<body>

<!-- Header Area -->
<div id="header" class="header header-size standard-colors">
    <a class="link-text header-size" href="#"><img name="logo-header" src="assets/logo.png"></a>
</div>


<!--<div id="test"></div>-->

<!-- Search Area -->
<div id="filter-app">
    <h1 class="center">Search Resource Directory</h1>
    <div class="search-area">
        <h4 class="center greytext">Filter by Name</h4>

        <div id="search-bar">
            <selector :options="['Homeless Shelter of El Paso', 'Opportunity Center']"
                      :text="'Name of Organization'"
                      :multiple="false"
                      id="filter-name"></selector>
        </div>

        <h4 class="center greytext">Or</h4>
        <h4 class="center greytext">Filter by Criteria</h4>

        <div id="search-filter-area">
            <selector :options="['service prop 1', 'service prop 2', 'service prop 3']"
                      :multiple="true"
                      :text="'Filter by Services'"
                      class="selector-sm"
                      id="filter-service"></selector>
            <selector :options="['keyword prop 1','keyword prop 2']"
                      :multiple="true"
                      :text="'Filter by Keywords'"
                      class="selector-sm"
                      id="filter-keyword"></selector>
            <selector :options="['area prop 1', 'area prop 2', 'area prop 3']"
                      :multiple="true"
                      :text="'Filter by Location'"
                      class="selector-sm" id="filter-area"></selector>

            <div class="center" id="search-button container">
                <button id="search-button" :disabled="disable"
                        onclick="sendFilterQuery()" v-on:click="welcome = false">
                    <img class="center" src="assets/baseline-search-24px.svg">
                    Search
                </button>
            </div>
        </div>
    </div>

    <div id="banner-welcome" class="banner-welcome" v-if="welcome">
        <h1 class="center">Welcome to the El Paso Resource Directory for People Experiencing Homelessness</h1>

        <h2>This resource directory is designed to be an ever-evolving guide of services available to people experiencing homelessness in El Paso, TX. The main goal of the directory is to expand the range of referral services in our community by facilitating interagency collaboration. Feel free to download a copy of this directory for your own records. We appreciate your continued commitment to providing those facing homelessness with the best, culturally competent care.<br/><br/>
            DISCLAIMER: Due to the ever-changing nature of programs, organizations, and agencies, no guarantee is given that all information is up-to-date and accurate. The directory is meant to be a GUIDE, so contacting the agencies prior to referral is recommended. </h2>
    </div>

</div>

<!-- Used as the image preloader --><img style="float: left; margin: 0; padding: 0; width:0; height:0; visibility: hidden;" src="assets/loading_circle_tic.gif">
<div id="table-app" v-if="isVisible">
    <div id="load-img" v-if="isLoading || isVisible" class="table-app-border"></div>
    <div class="center" v-if="isLoading"><img class="center" src="assets/loading_circle_tic.gif"></div>

    <transition name="fade">
    <div class="results-container" v-if="isVisible">
        <h1 class="center">Results</h1>
        <table id="results-table">
            <!-- Table Headers -->
            <thead>
            <tr>
                <!-- <th></th> -->
                <th>Keywords</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Website</th>
                <th>Up To Date?</th>
            </tr>
            </thead>

            <!-- Table Row Entries -->
            <tbody>

            <template v-for="(org, ind) in orgs">
                <table-row :id="ind" :org-data="org" @expand="expand"></table-row>

                <template>
                    <!-- <transition name="slide"> -->
                    <table-subrow v-if="ind in expanded && expanded[ind]" :org-data="org"></table-subrow>
                    <!-- </transition> -->
                </template>
            </template>

            </tbody>
        </table>
        <h4 class="center">Your search returned {{ orgs.length }} results.</h4>

    </div>
    </transition>
</div>


<!-- Footer area -->
<div id="footer" class="footer footer-size standard-colors">
    <div class="footer-quicklinks footer-size">
        <ul class="footer-quicklinks-items footer-size">
            <li class="footer-quicklinks-item"><a href="https://homelessopportunitycenter.org">Home</a></li>
            <li class="footer-quicklinks-item"><a href="#">Resources</a></li>
            <li class="footer-quicklinks-item"><a href="login.php">Login</a></li>
        </ul>
    </div>
</div>


<!-- DO NOT REMOVE!!! SCRIPTS NEEDED!!! -->
<!-- VueJS imports -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script type="text/javascript" src="scripts/searchVue.js"></script>
<script src="scripts/SearchRequest.js"></script>

</body>
</html>