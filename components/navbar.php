<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#"> <img src="./img/logo.png" class="me-1 topLogo rounded-circle border" alt=""><?php echo $_SESSION['business_name'];?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <div class="d-flex" role="search">
                    <input class="form-control me-5" type="search" placeholder="Search" aria-label="Search">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-column mx-4">
                            <small><?php echo $_SESSION['name'];?></small>
                            <small>Admin</small>
                        </div>
                        <img class="topLogo rounded-circle border" src="./img/logo.png " alt="">
                    </div>

                </div>
            </div>
        </div>
    </nav>