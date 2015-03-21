<?php
namespace SimoTod\SlimDownload;

class DownloadView implements \Pimple\ServiceProviderInterface
{
	protected response;
	
	protected $app;
	
    public function register(\Slim\App $container)
    {
        $container['view'] = $this;
		$this->app = $container;
    }
    
    public function render($path, $data = []) 
    {        
        $contentType = $data["CONTENT_TYPE"] ? $data["CONTENT_TYPE"] : 'application/octet-stream';
        $filename = $data["FILENAME"] ? $data["FILENAME"] : basename($path);
		
		$newResponse = $this->app->response->withStatus(200)
			->withHeader('Content-Type', $contentType)
			->withAddedHeader('Content-Transfer-Encoding', 'Binary');
			->withAddedHeader('Content-disposition', 'attachment; filename="'.$filename.'"')
			->withAddedHeader('Content-Length', filesize($path))
			->withAddedHeader('Expires', '0')
			->withAddedHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
			->withAddedHeader('Pragma', 'public')
			->withBody(new Body(fopen($path, 'r')));

        $this->app->stop($newResponse);
    }
}