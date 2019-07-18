<?php
/**
 *
 */
class Commentaire
{
    private $_idcommentaire;
    private $_contentcommentaire;
    private $_createdate;
    private $_useriduser;
    private $_articleidarticle;
    private $_valide;
    private $_namearticle;
    private $_pseudo;



    
    public function __construct($data)
    {
        return $this->hydrate($data);
    }
    /**
     *
     * @return type
     */
    public function getIdCommentaire()
    {
        return $this->_idcommentaire;
    }
    
    public function getContentCommentaire()
    {
        return $this->_contentcommentaire;
    }
    
    /**
     *
     * @return type
     */
    public function getCreateDate()
    {
        return $this->_createdate;
    }
    
    public function getUseriduser()
    {
        return $this->_useriduser;
    }
    
    public function getArticleidArticle()
    {
        return $this->_articleidarticle;
    }
    
    public function getValide()
    {
        return $this->_valide;
    }
    
    public function getNameArticle(){
        
        return $this->_namearticle;
    }
    
    public function getPseudo(){
        
        return $this->_pseudo;
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
    
    
    public function setIdCommentaire($idcommentaire)
    {
        $this->_idcommentaire =$idcommentaire;
    }
    
    public function setContentCommentaire($contentcommentaire)
    {
        $this->_contentcommentaire =$contentcommentaire;
    }
    
    public function setCreateDate($createdate)
    {
        $this->_createdate=$createdate;
    }
    
    public function setUseriduser($useriduser)
    {
        $this->_useriduser = $useriduser;
    }
    
    public function setArticleidArticle($articleidarticle)
    {
        $this->_articleidarticle = $articleidarticle;
    }
    
    public function setValide($valide)
    {
        $this->_valide = $valide;
    }
    
    public function setNameArticle($namearticle){
        
        $this->_namearticle = $namearticle;
    }
    
    public function setPseudo($pseudo){
        
        $this->_pseudo = $pseudo;
    }
}
