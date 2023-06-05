<?php include 'request.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сервис сокращения ссылок</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
    <div class="container text-center">
        <div class="row top">
            <a href="/">
                <h1>Сервис сокращения ссылок</h1>
            </a>
        </div>
        <div class="row">
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" value="<?=$_GET['cut_link'];?>" name="cut_link" class="form-control" placeholder="Вставьте ссылку, которую нужно сократить" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" name="submit" type="submit" id="button-addon2">Сократить</button>
                    <img src="" alt="">
                </div>
                <?if (!empty($_GET['cut_link'])) {?>
                    <?
                    $length = strlen($_SERVER["SERVER_NAME"]);
                    $str = substr($_GET['cut_link'], $length);
                    ?>
                    <div class="link">
                        <a href="<?=$str?>" target="_blank"><?=$_GET['cut_link']?></a>
                    </div>
                <?}?>
                <?if (array_key_exists('submit',$_GET) && !empty($_GET["cut_link"])) {
                    echo '<img src="'.$_GET['file'].'" alt="">';
                }?>
            </form>
        </div>
    </div>
</body>
</html>