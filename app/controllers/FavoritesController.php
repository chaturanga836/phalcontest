<?php
use \Phalcon\Http\Response;


class FavoritesController extends \Phalcon\Mvc\Controller
{


    public function indexAction()
    {
        $this->view->setLayoutsDir('View/favorites/');
        $this->view->pick('favorites/general');
        
       if( $this->session->get('auth') === null){

           return $this->response->redirect('');
       }
    }


    /**
     *
     * this method is an ajax method
     * get tha list of data with favorites
     *
     * @param int $page
     * @return Response
     */
    public function getListAction($page =1)
    {




        $user_id = $this->session->get('auth');

        $favorites = new Favorites();
        $data = $favorites->getFavorites($user_id,$page);


        $response = new Response();



        $response->setStatusCode(200, "OK");
        $response->setContent( json_encode($data));

        return $response;

    }

    /**
     * this method is an ajax method
     * use to add/remove user favorites
     * @return Response
     */
    public function handleFavoritAction()
    {

        if (!$this->request->isPost()) {
            $response = new Response;
            $response->setStatusCode(400, "OK");
        }

        $rawbody = $this->request->getJsonRawBody();

        $id    = $rawbody->id;
        $image = $rawbody->image;

        $user_id = $this->session->get('auth');

        $favorite = new Favorites();
        $resp = $favorite->handleFavorites($user_id,$id,$image);

        $response = new Response();

        $response->setStatusCode(200, "OK");
        $response->setContent( json_encode($resp));

        return $response;

    }

}

