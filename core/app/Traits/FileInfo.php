<?php

namespace App\Traits;

trait FileInfo{

	public function fileInfo(){
		$data['gateway'] = [
	        'path' => 'assets/images/gateway',
	        'size' => '800x800',
	    ];
	    $data['verify'] = [
	        'withdraw'=>[
	            'path'=>'assets/images/verify/withdraw'
	        ],
	        'deposit'=>[
	            'path'=>'assets/images/verify/deposit'
	        ]
	    ];
	    $data['image'] = [
	        'default' => 'assets/images/default.png',
	    ];
	    $data['withdraw'] = [
	        'method' => [
	            'path' => 'assets/images/withdraw/method',
	            'size' => '800x800',
	        ]
	    ];
	    $data['ticket'] = [
	        'path' => 'assets/support',
	    ];
	    $data['language'] = [
	        'path' => 'assets/images/lang',
	        'size' => '64x64'
	    ];
	    $data['logoIcon'] = [
	        'path' => 'assets/images/logoIcon',
	    ];
	    $data['favicon'] = [
	        'size' => '128x128',
	    ];
	    $data['extensions'] = [
	        'path' => 'assets/images/extensions',
	        'size' => '36x36',
	    ];
	    $data['seo'] = [
	        'path' => 'assets/images/seo',
	        'size' => '1180x600'
	    ];
	    $data['profile'] = [
	        'user'=> [
	            'path'=>'assets/images/user/profile',
	            'size'=>'350x300'
	        ],
	        'admin'=> [
	            'path'=>'assets/admin/images/profile',
	            'size'=>'400x400'
	        ]
	    ];

	    return $data;
	}

}
