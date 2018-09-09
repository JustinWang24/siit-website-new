<head>
    <?php
        // For AMP
        echo \App\Models\Utils\AMP\HeadUtil::getInstance()->output($pageTitle,$metaKeywords,$metaDescription );
        // For Other use: crsf, css, js
    /**
     *
        echo file_get_contents(app_path().'/../resources/assets/sass/frontend/fotorama.css'); // version 4.6.4
        echo file_get_contents(app_path().'/../public/css/app.css');
     */
    ?>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>

        .container {
        <?php
            if($agentObject->isPhone()){
                foreach (config('system.layout.container.mobile.styles') as $key=>$value) {
                    echo !empty($value) ? $key.':'.$value.' !important;' : null;
                }
            }else{
                foreach (config('system.layout.container.desktop.styles') as $key=>$value) {
                    echo !empty($value) ? $key.':'.$value.' !important;' : null;
                }
            }
        ?>
        }

        <?php
        if(app()->getLocale()=='cn'){
            ?>
            h1,h2,h3,h4,h5,p,span,a,li,td{
                font-family: 'Microsoft YaHei', '宋体' !important;
            }
            <?php
        }
        ?>
    </style>
</head>