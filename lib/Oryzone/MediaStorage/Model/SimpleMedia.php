<?php

namespace Oryzone\MediaStorage\Model;

class SimpleMedia extends Media
{

    /**
     * @var mixed $id
     */
    protected $id;

    /**
     * Sets the media id
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }
}
