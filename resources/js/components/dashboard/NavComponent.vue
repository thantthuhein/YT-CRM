<template>
    <div class="nav-main main-font">
        <nav class="nav-component main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav push-menu">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="white-color fa fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <div class="search-container">
                <i class="fa fa-search white-color" aria-hidden="true"></i>
                <form :action="searchRoute" method="GET">
                    <input type="text" name='q' 
                        :value="query"
                        placeholder="Search By quotation number, company name, project name" 
                        @keyup.enter="this.form.submit()"/>
                </form>
            </div>
            <div class="user-name">{{ currentUsername }}</div>
            <div class="bell px-3"><i class="far fa-bell white-color"></i></div>
            <div class="power-off">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="fas fa-power-off white-color"></i>
                </a>
                </div>

        </nav>

    </div>
</template>
<script>
export default {
    props: ['currentUsername', 'searchRoute', 'query']
}
</script>