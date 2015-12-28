<?php
class StaticUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route === 'static/page') {
            if (isset($params['page_id'])) {
                $page = StaticPages::model()->findByPk($params['page_id']);
                if ($page) {
                    if ($page->parent != 0) {
                        $array = array_merge(array($page->alias), $this->toparent($page->parent));
                    } else {
                        $array = array($page->alias);
                    }
                    return implode("/", array_reverse($array)) . $manager->urlSuffix;
                }
            }
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $url = $pathInfo;
        $pages = array();
        if (strpos($url, '/') !== false) {
            $urlPieces = explode('/', $url);

            $parent = 0;
            $page = null;

            foreach ($urlPieces as $item) {
                $item1 = StaticPages::model()->findByAlias($item, $parent);
                if ($item1) {
                    if ($parent == 0)
                        $_GET['parent_id'] = $item1->id;
                    $page = $item1;
                    $parent = $item1->id;
                    $pages[] = array("id" => $page->id, "title" => $page->header, "url" => $page->alias, "isCat" => $page->iscat);
                } else {
                    $page = null;
                    break;
                }
            }


        } else {
            $page = StaticPages::model()->findByAlias($url);
            if (!$page)
                return false;
            $pages = array(array("id" => $page->id, "title" => $page->header, "url" => $page->alias, "isCat" => $page->iscat));
        }
        if ($page != null && $page->iscat == 0) {
            $_GET['page_id'] = $page;
            $_GET['pages'] = $pages;
            return 'Static/static';
        } else {
            throw new CHttpException(404);
        }
    }

    private
    function toparent($parent = 0)
    {
        $page = StaticPages::model()->findByPk($parent);
        if ($page) {
            $url = array($page->alias);
            if ($page->parent != 0)
                return array_merge($url, $this->toparent($page->parent));
            else
                return $url;
        } else {
            throw new CHttpException(503);
        }
    }
}