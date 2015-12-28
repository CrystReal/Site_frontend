<?php

/**
 * Created by Alex Bond.
 * Date: 18.01.14
 * Time: 16:54
 */
class ProfileController extends MainController
{
    public function actionList()
    {
        $this->render("list");
    }

    public function actionGetJSON()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $keys = Yii::app()->redis->keys("allUsers_*" . $_GET['p'] . "*");
            $out = [];
            foreach ($keys as $item) {
                $id = Yii::app()->redis->get($item);
                if ($id != "needAct") {
                    $out[] = [
                        "username" => str_replace("allUsers_", "", $item),
                        "id" => $id,
                        "html" => Users::model()->getUsernameWithAvatarAndLink($id, 35)
                    ];
                }
            }
            echo json_encode($out);
        }
    }

    public function actionView()
    {
        /**
         * @var $profile Users
         */
        $profile = Users::model()->findByPk($_GET['id']);
        if (!$profile)
            throw new CHttpException(404, "Игрок не найден");
        if ($_GET['nickname'] != $profile->username)
            $this->redirect($profile->getProfileLink());
        $this->Title = "Профиль " . $profile->username;
        $this->render("view", ['model' => $profile]);
    }

    public function actionAvatar()
    {
        header("Content-type: image/png");

        if (isset($_GET['username']) && isset($_GET['size'])) {
            $name = $_GET['username'];
            $size = $_GET['size'] > 0 ? $_GET['size'] : 100;
        } else {
            $name = "Player";
            $size = 100;
        }

        $cache = Yii::app()->redisCache->get("userHead:" . $name . ":" . $size);
        if (!empty($cache)) {
            echo $cache;
            die();
        }

        $src = @imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/{$name}.png");

        if (!$src) {
            $src = imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/char.png");
        }

        $dest = imagecreatetruecolor(8, 8);
        imagecopy($dest, $src, 0, 0, 8, 8, 8, 8); // copy the face

        $bg_color = imagecolorat($src, 0, 0);
        $no_helm = true;

        for ($i = 1; $i <= 8; $i++) {
            for ($j = 1; $j <= 8; $j++) {
                // scanning helm area
                if (imagecolorat($src, 40 + $i, 7 + $j) != $bg_color) {
                    $no_helm = false;
                }
            }

            if (!$no_helm)
                break;
        }

        //if (!$no_helm) {
        imagecopy($dest, $src, 0, -1, 40, 7, 8, 8);
        //}

        $final = imagecreatetruecolor($size, $size);
        imagecopyresized($final, $dest, 0, 0, 0, 0, $size, $size, 8, 8);

        ob_start();
        imagepng($final);
        $stringdata = ob_get_contents();
        Yii::app()->redisCache->setex("userHead:" . $name . ":" . $size, 86400, $stringdata);

        imagedestroy($final);
    }
} 