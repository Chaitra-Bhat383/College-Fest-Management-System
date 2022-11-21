<?php
function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
    return [$first_name, $last_name];
}

$links = [
    'dashboard.php' => 'Dashboard',
    'organisers.php' => 'Organisers',
    'registrations.php' => 'Registrations',
    'sponsors.php' => 'Sponsors',
    'dialog_box.php' => 'Query',
];
?>

<div class="bg-primary">
    <div class="container pt-5">
        <div class="d-flex align-items-center">
            <span class="btn btn-icon btn-lg btn-light rounded-circle mr-3">
                <span class="btn-icon__inner">
                    <?php
                    $names = $_SESSION['user_id'];
                    
                    ?>
                </span>
            </span>
            <span>
                <h1 class="h3 text-white font-weight-medium mb-2">Howdy,
                    <span class="font-weight-normal"><?= $_SESSION['user_id']; ?></span>
                </h1>
                
            </span>
        </div>
        <div class="d-flex align-items-end justify-content-between py-3">
            <ul class="nav dash-head-nav">
                <?php
                foreach ($links as $href => $title) { ?>
                <li
                    class="<?= basename($_SERVER['PHP_SELF']) === $href ? 'nav-item active' : 'nav-item'; ?>">
                    <a href="<?= $href ?>"
                        class="nav-link"><?= $title ?></a>
                </li>
                <?php } ?>
            </ul>
            <a class="btn btn-outline-light btn-sm transition-3d-hover"
                href="select.php">
                <span class="fas fa-plus small mr-2"></span>
                New Registration
            </a>
        </div>
    </div>
</div>
