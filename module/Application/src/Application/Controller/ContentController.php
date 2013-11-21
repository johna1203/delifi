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

        if(preg_match('/^(http|https):\/\//i', $url)) {
            echo 'match';
        }

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
                        $src      = $_img->getAttribute('src');
                        if(preg_match('/^(http|https):\/\//i', $src)) {
                            $imageUrl = $src;
                        } else {
                            $imageUrl = $baseUrl . '/' . $src;
                        }

                        if (!in_array(md5($imageUrl), $md5)) {
                            $images[] = $imageUrl;
                            $md5[] = md5($imageUrl);
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


}

