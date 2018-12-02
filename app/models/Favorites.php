<?php
use App\Service\RequestService;
use Phalcon\Mvc\Model\Query\Builder as QBuilder;
use Phalcon\Mvc\Url;

class Favorites extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $image_id;

    /**
     *
     * @var string
     */
    public $image_name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcontest");
        $this->setSource("Favorites");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Favorites';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Favorites[]|Favorites|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Favorites|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * method use to get the date from api and bind with use favorites
     *
     * @param $user_id
     * @param $page
     * @return mixed
     */
    public function getFavorites($user_id, $page)
    {


        $url = "mars-photos/api/v1/rovers/curiosity/photos";

        $service = new RequestService;
        $data = $service->get($url, ['sol' => $page]);

        $photoes = $data['response']['photos'];

        $pic_index = array_column($photoes, 'id');


        $saved_favorites = self::query()->where('user_id=:user_id:')
            ->andWhere('image_id IN ('.implode(",",$pic_index).')')
            ->bind(['user_id' => $user_id])
            ->execute();


        $pic_index = array_flip($pic_index);

        foreach ($saved_favorites as $val) {

            $obj_ind = $pic_index[$val->image_id];

            $photoes[$obj_ind]['status'] = true;
        }



        return $photoes;
    }

    /**
     * add or remove favorites
     * find the image already saved in local
     * if not, save image in local
     *
     * @param $user_id
     * @param $image_id
     * @param $image
     * @return array
     */
    public function handleFavorites($user_id, $image_id, $image)
    {


        $images = Images::findFirst([

            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $image_id
            ]
        ]);




        if ($images === false) {

            $arr_cont = explode('/', $image);

            $image_name = $arr_cont[count($arr_cont) - 1];


            $images = new Images();
            $images->id = $image_id;
            $images->image = $image_name;
            $images->save();

            $img_save_location = 'img/' . $image_name;

            $resp = @file_put_contents($img_save_location, file_get_contents($image));

        }

        $current_favorite = self::findFirst([
            'conditions' => 'user_id = :user_id: AND image_id =:image_id:',
            'bind' => [
                'user_id' => $user_id,
                'image_id' => $image_id
            ]
        ]);


        if ($current_favorite === false) {

            $this->user_id = $user_id;
            $this->image_id = $image_id;
            $this->image_name = $images->image;
            $this->save();

            $status = true;
        } else {
            $current_favorite->delete();
            $status = false;
        }

        return [
            'id' => $image_id,
            'status' => $status
        ];
    }

}
