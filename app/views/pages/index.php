<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="<?=assets('styles/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=assets('styles/endless.min.css')?>">
</head>
<body class="overflow-hidden">
<!-- Overlay Div -->
<div id="wrapper" class="sidebar-hide">
    <div id="main-container">
        <div id="breadcrumb">
            <ul class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="index.html"> Home</a></li>
                <li class="active">Blank page</li>
            </ul>
        </div><!-- breadcrumb -->
    </div><!-- /main-container -->
</div>
<a href="" id="theme-setting-icon"><i class="fa fa-cog fa-lg"></i></a>
<a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>


<script src="<?=assets('scripts/jquery-1.11.3.min.js')?>"></script>
<script src="<?=assets('scripts/bootstrap.min.js')?>"></script>
<script src='<?=assets('scripts/modernizer.min.js')?>'></script>
<script src='<?=assets('scripts/pace.min.js')?>'></script>
<script src='<?=assets('scripts/jquery.popupoverlay.min.js')?>'></script>
<script src='<?=assets('scripts/jquery.slimscroll.min.js')?>'></script>
<script src='<?=assets('scripts/jquery.cookie.min.js')?>'></script>
<script src="<?=assets('scripts/endless.js')?>"></script>

</body>
</html>
