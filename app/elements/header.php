<header class="app-header" style="position: absolute; top: 0; background-color: aliceblue; height: 70px;">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>

        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <span style="margin-right: 1rem"><?= $login !== "" ? $login : 'Гость' ?></span>
                        <?= $login === "admin" ? '<img src="bootstrap/assets/images/profile/romaIcon.jpg" alt="" width="35" height="35" class="rounded-circle">' :
                            '<img src="../bootstrap/assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">' ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <?php if ($login != ""): ?>
                            <a onclick="location.href=`index.php?usersAdm`" class="btn btn-outline-primary mx-3 mt-2 d-block">Пользователи</a>
                        <?php endif; ?>
                        <div class="message-body">
                            <?= $login != "" ? '<a onclick="location.href=`index.php?logout`" class="btn btn-outline-primary mx-3 mt-2 d-block">Выход</a>' : '<a onclick="location.href=`app/pages/login.php`" class="btn btn-outline-primary mx-3 mt-2 d-block">Вход</a>' ?>
                        </div>

                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>