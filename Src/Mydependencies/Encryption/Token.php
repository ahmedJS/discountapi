<?php 
namespace MyDeps\Encryption;

/**
 * it behave like a container of many properties such as 
 * $token , expired , $content
 * the first it injected throgh the object constructor and the rest will generated automatecly
 */
class Token {
    protected IEncrypt $enc_lib;
    private string $token;
    private int $state;
    private mixed $content;

    function __construct(IEncrypt $enc_lib)
    {
        $this->enc_lib = $enc_lib;
    }

    function generateDetails($token,$key,$allowed_alg=[]){
        $state = State::VALID;
        $content = null;
        try{
            $content = $this->enc_lib->decode($token , $key , $allowed_alg);
        }catch(\Firebase\JWT\BeforeValidException $e){
            $state = State::BEFOREVALID;
        }catch(\Firebase\JWT\ExpiredException $e){
            $state = State::EXPIRED;
        }catch(\Firebase\JWT\SignatureInvalidException $e){
            $state = State::INVALID;
        }

        $this->token = $token;
        $this->state = $state;
        $this->content = $content;
    }
    
    /**
     * @return Array Containing content and expired or not
     */
    function GetDetails(){
        return [
            "token" => $this->getToken,
            "state" => $this->getState,
            "content" => $this->getContent
        ];
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }
}

