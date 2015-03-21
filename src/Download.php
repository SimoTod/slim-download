<?php
namespace SimoTod\SlimDownload;

use Psr\Http\Message\ResponseInterface;

class Download implements \Pimple\ServiceProviderInterface
{	
    public function register(\Pimple\Container $container)
    {
        $container['download'] = $this;
    }
    
    public function create(ResponseInterface $response, $path, $data = []) 
    {        
        $contentType = $data["CONTENT_TYPE"] ? $data["CONTENT_TYPE"] : 'application/octet-stream';
        $filename = $data["FILENAME"] ? $data["FILENAME"] : basename($path);
		
		$newResponse = $response->withStatus(200)
			->withHeader('Content-Type', $contentType)
			->withAddedHeader('Content-Transfer-Encoding', 'Binary');
			->withAddedHeader('Content-disposition', 'attachment; filename="'.$filename.'"')
			->withAddedHeader('Content-Length', filesize($path))
			->withAddedHeader('Expires', '0')
			->withAddedHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
			->withAddedHeader('Pragma', 'public');
		
        ob_start();
        readfile($path);
        $content = ob_get_clean();
		$newResponse = $newResponse->withBody($content);

        return $newResponse;
    }
}