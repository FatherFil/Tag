<?php

/**
 * Created by PhpStorm.
 * User: phil.collins
 * Date: 18/01/2016
 * Time: 12:26
 */
class Tweet
{

    private $_id;
    private $_text;
    private $_created_at;
    private $_author_id;
    private $_author_screen_name;
    private $_author_profile_image_url;
    private $_author_timezone;
    private $_json;

    public function __construct($id,$text,$created,$author_id,$author_name,$profileImageUrl,$timezone,$json) {
        $this->_id = $id;
        $this->_text = $text;
        $this->_created_at = $created;
        $this->_author_id = $author_id;
        $this->_author_screen_name = $author_name;
        $this->_author_profile_image_url = $profileImageUrl;
        $this->_author_timezone = $timezone;
        $this->_json = $json;
    }

    public function outputTweet() {
        return $this->_id ." ". $this->_author_screen_name .": ". $this->_text;
    }

    public function getID() {
        return $this->_id;
    }

    public function getText() {
        return $this->_text;
    }

    public function getCreatedAt() {
        return $this->_created_at;
    }

    public function getAuthorID() {
        return $this->_author_id;
    }

    public function getAuthorName() {
        return $this->_author_screen_name;
    }

    public function getProfileImageURL() {
        return $this->_author_profile_image_url;
    }

    public function getTimezone() {
        return $this->_author_timezone;
    }

    public function getJSON() {
        return $this->_json;
    }

}