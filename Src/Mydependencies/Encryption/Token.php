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
    private bool $expired;
    private array $content;

    function __construct(IEncrypt $enc_lib)
    {
        $this->enc_lib = $enc_lib;
    }

    function generateDetails($token,$key,$allowed_alg=[]){
        try{
            $this->enc_lib->decode($token , $key , $allowed_alg);
        }catch(\Exception $e){
            // handle exception of each type of jwt exception
        }
    }
    
    /**
     * @return Array Containing content and expired or not
     */
    function GetDetails(){
        
    }
}

