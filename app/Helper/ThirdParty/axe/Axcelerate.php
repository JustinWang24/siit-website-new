<?php

namespace FlipNinja\Axcelerate;

use FlipNinja\Axcelerate\Connection\ConnectionContract;
use FlipNinja\Axcelerate\Connection\HttpConnection;
use FlipNinja\Axcelerate\Contacts\ContactManager;
use FlipNinja\Axcelerate\Courses\CourseManager;
use FlipNinja\Axcelerate\Users\UserManager;

class Axcelerate
{
    const PRODUCTION_BASE = 'https://api.axcelerate.com.au/api/';
    const STAGING_BASE = 'https://stg.axcelerate.com.au/api/';

    /** @var ConnectionContract $connection */
    protected $connection;

    /** @var ContactManager $contacts */
    protected $contacts;

    /** @var CourseManager $courses */
    protected $courses;

    /** @var UserManager $users */
    protected $users;

    /**
     * Initialise the aXcelerate library
     *
     * @param string $apiToken
     * @param string $wsToken
     * @param string $base Base URI for aXcelerate
     */
    public function __construct($apiToken, $wsToken, $base)
    {
        $this->connection = new HttpConnection($base, $apiToken, $wsToken);
    }

    /**
     * Get the manager for contacts
     *
     * @return ContactManager
     */
    public function contacts()
    {
        return $this->contacts ?: $this->contacts = new ContactManager($this->connection);
    }

    /**
     * Get the manager for courses
     * @return CourseManager
     */
    public function courses()
    {
        return $this->courses ?: $this->courses = new CourseManager($this->connection);
    }

    /**
     * Get the manager for Axcelerate users
     * Created and appended by Justin Wang
     * @return UserManager
     */
    public function users(){
        return $this->users ?: $this->users = new UserManager($this->connection);
    }
}
