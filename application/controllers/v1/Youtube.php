<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Youtube extends REST_Controller {

	public function __construct(){
		
		parent::__construct();
		$this->load->helper('url','file');
		//$this->load->libraries('database');
	}
	
	public function index(){}
	
	
	// Get playlist detail using youtube channel id 
	/* 
		Parameter :
			channel_id = youtube channel id
			key = access_token generated by devloper account.
	*/
	public function playlist_get(){
		
		$channel_id = $this->get('channel_id');
		$access_token = $this->get('key');
		
		if(empty($channel_id)){
			$this->response(array('status'=>'failure','message' => 'channel_id required'), 400);
		}elseif(empty($access_token)){
			$this->response(array('status'=>'failure','message' => 'key required'), 400);
		}else{
			$url = 'https://www.googleapis.com/youtube/v3/playlists?key='.$access_token.'&channelId='.$channel_id.'&maxResults=10&fields=pageInfo(totalResults),items(id,snippet(publishedAt,title))&part=snippet';
			
			$response = json_decode(file_get_contents($url),true);
			
			$this->response(array('status'=>'success','total_records' => $response['pageInfo']['totalResults'],'data' => $response['items']), 200);
		}
	}
	
	public function playlistitems_get(){
		
		$access_token = $this->get('key');
		$playlistid = $this->get('id');
		
		if(empty($playlistid)){
			$this->response(array('status'=>'failure','message' => 'playlist id required'), 400);
		}elseif(empty($access_token)){
			$this->response(array('status'=>'failure','message' => 'key required'), 400);
		}else{
			$url = 'https://www.googleapis.com/youtube/v3/playlistItems?key='.$access_token.'&playlistId='.$playlistid.'&maxResults=10&fields=pageInfo(totalResults),items(snippet(publishedAt,title,description,thumbnails,resourceId(videoId)))&part=snippet';
			
			$response = json_decode(file_get_contents($url),true);
			
			$this->response(array('status'=>'success','total_records' => $response['pageInfo']['totalResults'],'data' => $response['items']), 200);
		}
	}
	
	
}
?>