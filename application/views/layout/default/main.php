<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= $title ?></title>
    <!-- Bootstrap Styles-->
    <link href="<?= site_url('assets/css/bootstrap.css') ?>" rel="stylesheet"/>
    <!-- FontAwesome Styles-->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <link href="<?= site_url('assets/lib/datatables/css/jquery.dataTables.css') ?>" rel="stylesheet"/>
    <link href="<?= site_url('assets/css/dataTables.CSV.css') ?>" rel="stylesheet"/>
    <link href="<?= site_url('assets/css/chardinjs.css') ?>" rel="stylesheet"/>

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">


    <!-- Custom Styles-->
    <link href="<?= site_url('assets/css/custom-styles2.css?v=2') ?>" rel="stylesheet"/>
    <script type="text/javascript">
        var Easol_SiteUrl = "<?= site_url('/') ?>"
    </script>

    <?php if(($this->router->class=='reports') || ($this->router->class=='dashboard' && $this->router->method =='index') ) { ?>
        <link href="<?= site_url('assets/lib/nvd3/nv.d3.min.css') ?>" rel="stylesheet"/>
        <script src="<?= site_url('assets/lib/nvd3/d3.min.js') ?>"></script>
        <script src="<?= site_url('assets/lib/nvd3/nv.d3.min.js') ?>"></script>
    <?php } ?>

    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="1046550702050-or91v65jm72mmdv8tjesehm3qbq3d4ol.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!--
    In an attempt to provide some order to the css , I am compartmentalizing my css into
    files named after the controller for which they are used and then dynamically loading those
    controller specific css files. -- S.Madison
    -->
    <?php if(file_exists(APPPATH.'../assets/css/'.$this->router->class.'.css')) : ?>
        <link href="<?= site_url('assets/css/'.$this->router->class.'.css') ?>" rel="stylesheet"/>
    <?php endif; ?>
</head>
<body>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="logo-header">
                <a class="navbar-brand" href="<?= site_url("/") ?>">
                    <img class="center-block" src="<?= site_url("assets/img/easollogo.png") ?>"/>
                </a>
            </div>
            <div class="collapse navbar-collapse sidebar-collapse menu-collapse">
                <?php if(Easol_Authentication::isLoggedIn() && Easol_Authentication::userdata('SchoolId')!=false) : ?>
                    <ul class="nav" id="main-menu">
                        <?php if(Easol_AuthorizationRoles::hasAccess(['System Administrator','Data Administrator'])):  ?>
                            <li class="visible-xs-block">
                                <form class="navbar-form" action="<?= site_url("schools/choose") ?>" method="post">
                                    <select name="school" class="form-control" onchange="this.form.submit()">
                                        <?php  foreach($this->Edfi_School->getAllSchools() as $school):  ?>
                                            <option value="<?= $school->EducationOrganizationId ?>" <?= (Easol_Authentication::userdata("SchoolId")==$school->EducationOrganizationId) ? "selected" : "" ?>><?= $school->NameOfInstitution ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </li>
                        <?php  elseif(Easol_Authentication::userdata('SchoolName')): ?>
                            <li class="visible-xs-block"><p class="navbar-text"><?= Easol_Authentication::userdata('SchoolName') ?></p></li>
                        <?php endif; ?>

                        <?php foreach (menu_items() as $slug=>$item): ?>

                            <?php if (!empty($item['auth']) && !Easol_AuthorizationRoles::hasAccess($item['auth'])) continue; ?>

                            <li class="<?php echo ($this->router->fetch_class() == $slug) ? 'active-menu' : '' ?>" <?php echo (isset($item['attr'])) ? $item['attr'] : '' ?>>
                                <a id="<?php echo $slug; ?>" href="<?php echo (isset($item['url'])) ?  site_url($item['url']) : site_url($slug) ?>">
                                    <i class="fa fa-<?php echo $item['icon'] ?>"></i>
                                    <?php echo $item['label'] ?>
                                </a>
                                <?php if (!empty($item['submenu'])): ?>

                                    <ul class="sub-menu">

                                        <?php foreach ($item['submenu'] as $submenu_slug => $submenu_item) :?>
                                            <li class="<?php echo ($this->router->fetch_class() == $submenu_slug) ? 'active-menu sublive' : '' ?>">
                                                <a id="<?php echo $submenu_slug; ?>" href="<?php echo (isset($submenu_item['url'])) ?  site_url($submenu_item['url']) : site_url($submenu_slug) ?>">
                                                    <?php echo $submenu_item['label'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                            </li>
                        <?php endforeach; ?>

                        <li <?= ($this->router->class=="admin") ? 'class="active-menu visible-xs-block"' : 'class="visible-xs-block"' ?>>
                            <a href="<?= site_url("/admin") ?>"><i class="fa fa-cog"></i> Administration</a>
                        </li>

                        <?php if(Easol_Authentication::isLoggedIn()): ?>
                            <li class="visible-xs-block">
                                <a href="<?= site_url("/home/logout") ?>" onClick="signOut();"><i class="fa fa-user"></i> Logout</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
    </div>

    <!--/. NAV TOP  -->
    <div id="navbar-wrapper">
        <nav class="navbar navbar-default navbar-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".menu-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <?php if(Easol_Authentication::isLoggedIn() && Easol_Authentication::userdata('SchoolId')!=false) { ?>
                <ul class="nav navbar-nav navbar-top-links navbar-right hidden-xs">
                    <?php if(Easol_AuthorizationRoles::hasAccess(['System Administrator','Data Administrator'])) {  ?>
                        <li><form class="navbar-form" action="<?= site_url("schools/choose") ?>" method="post">
                                <select name="school" class="form-control" onChange="this.form.submit()">
                                    <?php  foreach($this->Edfi_School->getAllSchools() as $school){  ?>
                                        <option value="<?= $school->EducationOrganizationId ?>" <?= (Easol_Authentication::userdata("SchoolId")==$school->EducationOrganizationId) ? "selected" : "" ?>><?= $school->NameOfInstitution ?></option>
                                    <?php } ?>
                                </select>
                            </form></li>
                    <?php } elseif(Easol_Authentication::userdata('SchoolName')){ ?>
                        <li><p class="navbar-text"><?= Easol_Authentication::userdata('SchoolName') ?></p></li>
                    <?php } ?>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <?php if(Easol_AuthorizationRoles::hasAccess(['System Administrator','Data Administrator'])) { ?>
                                <li <?= ($this->router->class=="admin") ? 'class="active-menu"' : '' ?>>
                                    <a href="<?= site_url("/admin") ?>">Administration</a>
                                </li>
                            <?php } ?>
                            <?php if($this->session->userdata('logged_in')== true)
                            { ?>
                                <li>
                                    <a href="<?= site_url("/home/logout") ?>" onClick="signOut();">Logout</a>
                                </li>
                            <?php } ?>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            <?php } ?>
        </nav>
    </div>

    <div id="page-wrapper">
        <div id="page-inner">
            <!-- Show flashdata messages for general confirmation/error messages -->
            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger"><?php echo $error ?></div>
            <?php }else if (!empty($success)) { ?>
                <div class="alert alert-success"><?php echo $success ?></div>
            <?php } ?>
            <?= $content ?>
            <div class="row">
                <div class="col-md-8 col-sm-8 txt-annotation">
                    This computer system is the property of EASOL. It is for authorized
                    use only.
                    Unauthorized or improper use of this system may result in civil charges and/or criminal penalties.
                </div>
            </div>
        </div>
        <!-- /. ROW  -->
        <footer></footer>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Bootstrap Js -->
<script src="<?= site_url('assets/js/bootstrap.min.js') ?>"></script>
<!-- Metis Menu Js -->

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>

<script src="<?= site_url('assets/lib/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= site_url('assets/js/dataTables/dataTables.CSV.js') ?>"></script>
<script src="<?= site_url('assets/js/dataTables/dataTables.bootstrapPagination.js') ?>"></script>
<script src="<?= site_url('assets/js/dataTables/dataTables.bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/js/chardinjs.min.js') ?>"></script>
<script src="<?= site_url('assets/js/js.cookie-2.0.4.min.js') ?>"></script>
<script src="<?= site_url('assets/js/custom.js') ?>"></script>
<script src="<?= site_url('assets/js/layout.js') ?>"></script>

<?php if ($this->router->class=='content') { ?>
    <script src="<?= site_url('assets/lib/list.min.js') ?>"></script>
<?php } ?>
<!--
In an attempt to provide some order to the js functions, I am compartmentalizing my js into
files named after the controller for which they are used and then dynamically loading those
controller specific js files. -- S.Madison
-->
<?php if(file_exists(APPPATH.'../assets/js/'.$this->router->class.'.js')) : ?>
    <script src="<?= site_url('assets/js/'.$this->router->class.'.js') ?>"></script>
<?php endif; ?>








<div id="loading-img" style="background: url(<?= site_url("assets/img/loading2.gif") ?>) no-repeat; position: fixed; bottom: 5px;right:5px; height: 11px;width: 43px;display: none">&nbsp;</div>
<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" style="display:none"></div><!-- we need this here for google logout to work -->
</body>
</html>
