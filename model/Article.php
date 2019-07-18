<?php
/**
 *
 */
class Article
{
    private $_idarticle;
    private $_namearticle;
    private $_categorie;
    private $_dirphoto;
    private $_datemodificationarticle;
    private $_content;
    private $_user_iduser;
    private $_createDate;
    private $_chapo;
    private $_auteur;



    
    public function __construct($data)
    {
        return $this->hydrate($data);
    }
    /**
     *
     * @return type
     */
    public function getIdArticle()
    {
        return $this->_idarticle;
    }
    
    public function getCreateDateArticle()
    {
        return $this->_createDate;
    }
    
    /**
     *
     * @return type
     */
    public function getNameArticle()
    {
        return $this->_namearticle;
    }
    
    public function getCategorie()
    {
        return $this->_categorie;
    }
    
    public function getDirphoto()
    {
        return $this->_dirphoto;
    }
    
    public function getContent()
    {
        return $this->_content;
    }
    
    public function getDateModificationArticle()
    {
        return $this->_datemodificationarticle;
    }
    
    public function getUser_iduser()
    {
        return $this->_user_iduser;
    }
    
    public function getChapo()
    {
        return $this->_chapo;
    }
    
    public function getAuteur()
    {
        return $this->_auteur;
    }




    public function hydrate($data)
    {
        foreach ($data as $key => $value) {     ////$key correcspont à l'attribut dans la bdd----$value correspond à la valeur dans la bdd

            $methode = 'set'.ucfirst($key);     //// ucfirst -> mé une majuscule à la premier lettre -> meth

            if (method_exists($this, $methode)) {
                $this->$methode($value);
            }
        }
    }
    
    
    public function setIdArticle($idarticle)
    {
        $this->_idarticle =$idarticle;
    }
    
    public function setDateModificationArticle($datemodificationarticle)
    {
        $this->_datemodificationarticle =$datemodificationarticle;
    }
    
    public function setCreateDateArticle($createDate)
    {
        $this->_createDate=$createDate;
    }
    
    public function setNameArticle($namearticle)
    {
        $this->_namearticle = $namearticle;
    }
    
    public function setCategorie($categorie)
    {
        $this->_categorie = $categorie;
    }
    
    public function setDirphoto($dirphoto)
    {
        $this->_dirphoto = $dirphoto;
    }
    
    public function setContent($content)
    {
        $this-> _content =$content;
    }

    /**
     * @param $useriduser
     */
    public function setUser_iduser($useriduser)
    {
        $this->_user_iduser=$useriduser;
    }
    
    
    public function checkDirphoto($_FILE, $idarticle)
    {
        $extention = new SplFileInfo($_FILES['photoAticle']['name']);
    
       
        
        if ($_FILES ['photoAticle']['error']== 0) {
            if (mb_strtolower($extention->getExtension()) =='png'or mb_strtolower($extention->getExtension()) == 'jpg') {
                if ($_FILES ['photoAticle']['size']<= 2000000) { //valeur en octets
                
                    $name = md5($_FILES['photoAticle']['name']); // modifier uid unique
                $destination = './public/img/'.$name.'.'.$extention->getExtension(); //
                
                
                move_uploaded_file($_FILES ['photoAticle']['tmp_name'], $destination);
                
                    $this->_dirphoto = $destination;
                
                    return true;
                }
            }
        } else {
            
            $dirphoto = new ManagerArticle();
            $data = $dirphoto->getDirphotoByIdarticle($idarticle);
            
//            die(var_dump($data));
            if ($data['Dirphoto'] == './public/img/product-fullsize.jpg' or empty($data['Dirphoto'])) {
                
                $destination = './public/img/product-fullsize.jpg';
                $this->_dirphoto = $destination;
                
                
            } else {

                
                $this->_dirphoto = $data['Dirphoto'];
            }

            
        
            return false;
        }
    }
    
    public function setChapo($chapo)
    {
        $this->_chapo = $chapo;
    }
    
    public function setAuteur($auteur)
    {
        $this->_auteur = $auteur;
    }
}
