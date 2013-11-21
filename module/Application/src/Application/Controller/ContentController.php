<?php

namespace Application\Controller;

use Zend\Dom\Query;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Uri\UriFactory;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ContentController extends AbstractActionController
{

    public function indexAction()
    {
        $url = "http://www.keenthemes.com/preview/metronic_admin/extra_search.html";

        echo $this->makeUri($url, '../images/test.jpg');

        $uri = UriFactory::factory($url);

        return new ViewModel();
    }

    public function getcontentAction()
    {
        $url    = $this->params()->fromPost('url');
        $status = false;
        if (!empty($url)) {
            $uri    = UriFactory::factory($url);
            $config = array(
                'adapter'       => 'Zend\Http\Client\Adapter\Socket',
                'ssltransport'  => 'tls',
                'sslverifypeer' => false,
            );

            $client = new Client($url, $config);

            $response = $client->send();
            $title    = "";
            $images   = array();
            if ($response->isSuccess()) {
                $status  = true;
                $body    = $response->getBody();
                $dom     = new Query($body);
                $results = $dom->execute('title');

                if ($results->count() > 0) {
                    /** @var \DOMElement $current */
                    $current = $results->current();
                    $title   = $current->nodeValue;
                }


                //search Images
                $dom     = new Query($body);
                $results = $dom->execute('img');


                $path = $uri->getPath();

                if (!empty($path) && mb_substr($path, -1) != '/') {
                    $baseUrl = dirname($uri->toString());
                } else {
                    $baseUrl = $uri->toString();
                }


                if ($results->count() > 0) {
                    /** @var \DOMElement $_img */
                    $md5 = array();
                    foreach ($results as $_img) {
                        $src = $_img->getAttribute('src');
                        $imageUrl = $this->makeUri($uri->toString(),$src);

                        if (!in_array(md5($imageUrl), $md5)) {
                            $images[] = $imageUrl;
                            $md5[]    = md5($imageUrl);
                        }
                    }
                }
            }

            $json['data'] = array(
                'title'  => $title,
                'images' => $images
            );
        }

        $json['status'] = $status;

        $result = new JsonModel($json);

        return $result;
    }

    function makeUri($base = '', $rel_path = '')
    {
        $base  = preg_replace('/\/[^\/]+$/', '/', $base);
        $parse = parse_url($base);
        if (preg_match('/^https?\:\/\//', $rel_path)) {
            return $rel_path;
        } elseif (preg_match('/^\/.+/', $rel_path)) {
            $out = $parse['scheme'] . '://' . $parse['host'] . $rel_path;

            return $out;
        }
        $tmp = array();
        $a   = array();
        $b   = array();
        $tmp = explode('/', $parse['path']);
        foreach ($tmp as $v) {
            if ($v) {
                array_push($a, $v);
            }
        }
        $b = explode('/', $rel_path);
        foreach ($b as $v) {
            if (strcmp($v, '') == 0) {
                continue;
            } elseif ($v == '.') {
            } elseif ($v == '..') {
                array_pop($a);
            } else {
                array_push($a, $v);
            }
        }
        $path = join('/', $a);
        $out  = $parse['scheme'] . '://' . $parse['host'] . '/' . $path;

        return $out;
    }

}

