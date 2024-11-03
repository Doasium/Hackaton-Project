<header class="header mb-5">
    <nav class="navbar navbar-expand-lg container">
        <a class="navbar-brand" href="/"><img src="/uploads/logo.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/chat">ChatBot</a></li>
                <li class="nav-item"><a class="nav-link" href="/quests">Sorular</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                <?php

                use App\Controllers\UserController;
                use App\Models\UserModel;

                if ((new UserController())->getLogged()) { ?>
                    <li class="nav-item"><a class="nav-link" href="/logout"><span style="font-weight: bold;"><?= (new UserController())->getUserFullName(); ?></span></a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="/login"><span class="material-icons-outlined">account_circle</span></a></li>

                <?php } ?>
            </ul>
        </div>
    </nav>
</header>