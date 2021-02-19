<?php
	$stickers_id = [ 53697, 53744 ];


	$rand = $_GET['sticker_id'] ?? random_int($stickers_id[0], $stickers_id[1]);

	$headers = get_headers('https://vk.com/sticker/1-' . $rand . '-512');
	if(substr($headers[0], 9, 3) != 200) $rand = random_int($stickers_id[0], $stickers_id[1]);

	if(isset($_GET['vk'])) die('<script>window.location.href="https://vk.com/kkphp"</script>');
    elseif(isset($_GET['insta'])) die('<script>window.location.href="https://instagram.com/k.orolevsk.y"</script>');
    elseif(isset($_GET['gh'])) die('<script>window.location.href="https://github.com/k-orolevsk-y"</script>');
    elseif(isset($_GET['tg'])) die('<script>window.location.href="https://t.me/kkphp"</script>');
    elseif(isset($_GET['tt'])) die('<script>window.location.href="https://vm.tiktok.com/ZSbN4aau/"</script>');
?>
<!DOCTYPE html>
<html>
<!--
Привет-привет!
Ты наверное зашел сюда чтобы найти что-то интересное?
К сожалению тут ничего интересного нет.
Но интересное есть на моем github, загляни и посмотри, мне будет очень приятно 🥰
А ещё сайт умеет сам менять стикер.
Для этого добавь параметр anim=1. Если захочешь поменять скорость анимации, добавь speed_anim={время в мс}
-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Сайт веб-разработчика Кирилла Королевского с его контактными данными."/>
    <title>KOROLEVSKY.ME</title>
    <style>
        html {
            height: 100%;
        }
        body {
            display: flex;
            height: 100%;
            font-family: "Consolas", monospace;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .Sticker {
            margin: auto;
            font-size: 24px;
            background-image: url(https://vk.com/sticker/1-<?=$rand?>-512);
            width: 256px;
            height: 256px;
            background-position: center;
            background-size: cover;
            cursor: pointer;
            transition: opacity 147ms, transform 180ms cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .Sticker:hover {
            transform: scale(0.95);
        }
        .Sticker:active {
            transform: scale(0.9);
        }
        .Sticker--loading {
            opacity: 0;
            transform: scale(0.85);
        }

        .social-media {
            display: flex;
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-57%, -50%);
        }

        .social-media a {
            font-size: 64px;
            margin-left: 1.5em;
            animation: 4s ease forwards animation;
        }

        .social-media a:hover {
            transform: scale(1.3);
        }

        .vk {
            color: #2787F5;
        }

        .insta {
            color: pink;
        }

        .gh {
            color: #24292e;
        }

        .tg {
            color: #0088cc;
        }

        .tt {
            color: powderblue;
        }

        @media screen and (max-width: 414px) {
            .social-media a {
                font-size: 42px;
                margin-left: 0.8em;
            }
        }

        @media screen and (max-width: 320px) {
            .social-media a {
                font-size: 36px;
                margin-left: 0.5em;
            }
        }

        @keyframes animation {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q" crossorigin="anonymous">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <script src="js/lottie/lottie.js" type="text/javascript"></script>
</head>
<body>
<div class="Sticker" data-id="<?=$rand?>"></div>
<div class="social-media">
    <a href="https://vk.com/kkphp" target="_blank" class="vk"><i class="lni lni-vk"></i></a>
    <a href="https://instagram.com/k.orolevsk.y" target="_blank" class="insta"><i class="lni lni-instagram"></i></a>
    <a href="https://github.com/k-orolevsk-y" target="_blank" class="gh"><i class="lni lni-github"></i></a>
    <a href="https://vm.tiktok.com/ZSbN4aau/" target="_blank" class="tt"><i class="fab fa-tiktok"></i></a>
    <a href="https://t.me/kkphp" target="_blank" class="tg"><i class="lni lni-telegram"></i></a>
</div>

<?php if(!isset($_GET['anim'])): ?>
    <script>
        document.querySelector(".Sticker").onclick = function(e) {
            let item = this;
            if(item.classList.contains("Sticker--loading")) return;
            item.classList.add("Sticker--loading");

            let id = (parseInt(item.getAttribute("data-id")) || <?=$stickers_id[0]?>) + 1;
            if(id > <?=$stickers_id[1]?>) id = <?=$stickers_id[0]?>;
            item.setAttribute("data-id", id);
            item.innerHTML = "";

            let uri = "https://vk.com/sticker/1-"+ id + "-512";
            let animUri = "https://vk.com/sticker/3-" + id + "-0.json";

            fetch(animUri).then(() => {
                item.style.backgroundImage = 'url("")';

                lottie.loadAnimation({
                    container: document.getElementsByClassName('Sticker')[0],
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: animUri
                });

                setTimeout(() => {
                    item.classList.remove("Sticker--loading");
                }, 50);
            }).catch(() => {
                let img = new Image();

                img.onload = () => {
                    item.style.backgroundImage = "url("+ uri +")";
                    setTimeout(() => {
                        item.classList.remove("Sticker--loading");
                    }, 50);
                }

                setTimeout(() => {
                    img.src = uri;
                }, 200);
            })
        }
    </script>
    <script>
        window.onload = () => {
            let item = document.querySelector(".Sticker");
            let id = (parseInt(item.getAttribute("data-id")) || <?=$stickers_id[0]?>);
            let uri = "https://vk.com/sticker/1-"+ id + "-512";
            let animUri = "https://vk.com/sticker/3-" + id + "-0.json";

            fetch(animUri).then(() => {
                lottie.loadAnimation({
                    container: document.getElementsByClassName('Sticker')[0],
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: animUri
                });

                setTimeout(() => {
                    item.style.backgroundImage = "none";
                }, 150)

            }).catch(() => {
                let img = new Image();

                img.onload = () => {
                    item.style.backgroundImage = "url("+ uri +")";
                }

                setTimeout(() => {
                    img.src = uri;
                }, 200);
            })
        }
    </script>

<?php else: ?>
    <script>
        setInterval(function() {
            let item = document.querySelector(".Sticker");
            if(item.classList.contains("Sticker--loading")) return;
            item.classList.add("Sticker--loading");

            let id = (parseInt(item.getAttribute("data-id")) || <?=$stickers_id[0]?>) + 1;
            if(id > <?=$stickers_id[1]?>) id = <?=$stickers_id[0]?>;
            item.setAttribute("data-id", id);

            let uri = "https://vk.com/sticker/1-"+ id +"-512";
            let img = new Image();

            img.onload = () => {
                item.style.backgroundImage = "url("+ uri +")";
                setTimeout(() => {
                    item.classList.remove("Sticker--loading");
                }, 50);
            }

            setTimeout(() => {
                img.src = uri;
            }, 200);
        }, <?= $_GET['speed_anim'] == null || !is_numeric($_GET['speed_anim']) ? 500 : $_GET['speed_anim'] ?>);
    </script>
<?php endif; ?>
</body>
</html>
