<?php

// mix('css/app.css')
// mix('js/app.js')
function mix($path, $json = false, $shouldHotReload = false) 
{
	if (! $json) static $json;
	if (! $shouldHotReload) static $shouldHotReload;
	
	if (! $json) {
		$manifestPath = storage_path('framework/cache/Mix.json');
		$shouldHotReload = file_exists(storage_path('framework/cache/hot'));

		if (! file_exists($manifestPath)) {
			throw new Exception(
                'The Laravel Mix manifest file does not exist. ' . 
                'Please run "npm run webpack" and try again.'
            );
		}

		$json = json_decode(file_get_contents($manifestPath), true);
	}

	$path = collect($json['assetsByChunkName'])
	    ->flatten()
	    ->first(function ($compiledFile) use ($path, $json) {
	    	$compiledFile = trim(str_replace($json['hash'].'.', '', $compiledFile), '/');

	    	return $compiledFile === trim($path, '/');
	    });

	return $shouldHotReload ? "http://localhost:8080{$path}" : url($path);
}
