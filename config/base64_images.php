<?php
// config/base64_images.php

// $jataNegaraBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents("https://sijil.mpm.edu.my/build/images/jatanegara/JataNegara.png"));
// $mpmLogoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents("https://sijil.mpm.edu.my/build/images/logo-mpm-kuningpinang.jpg"));
// $signBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents("https://sijil.mpm.edu.my/build/images/sign/sign_new.png"));

$jataNegaraBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('build/images/jatanegara/JataNegara.png')));
$mpmLogoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('build/images/logo-mpm-kuningpinang.jpg')));
$signBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('build/images/sign/sign_new.png')));

