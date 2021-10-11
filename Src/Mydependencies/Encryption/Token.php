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
    private array $content;

    function __construct(IEncrypt $enc_lib)
    {
        $this->enc_lib = $enc_lib;
    }

    function generateDetails($token,$key,$allowed_alg=[]){
        $state = "";
        try{
            $this->enc_lib->decode($token , $key , $allowed_alg);
        }catch(\Firebase\JWT\BeforeValidException $e){
            $state = BEFOREVALID;
        }catch(\Firebase\JWT\ExpiredException $e){
            $state = EXPIRED;
        }catch(\Firebase\JWT\SignatureInvalidException $e){
            $state = INVALID;
        }
    }
    
    /**
     * @return Array Containing content and expired or not
     */
    function GetDetails(){
        
    }
}

