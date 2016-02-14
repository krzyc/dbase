<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace org\majkel\dbase;

use ArrayObject;

/**
 * Stores record data and status
 *
 * @author majkel
 */
class Record extends ArrayObject {

    const FLAG_DELETED = 1;

    /** @var integer[] [$fieldName => $entryId] */
    private $memoEntries;
    /** @var Flags */
    private $flags;

    /**
     * @return \org\majkel\dbase\Flags
     */
    protected function getFlagsField() {
        if (is_null($this->flags)) {
            $this->flags = new Flags();
        }
        return $this->flags;
    }

    /**
     * @param array $array
     */
    public function __construct($array = array()) {
        parent::__construct($array);
        $this->setFlags(ArrayObject::ARRAY_AS_PROPS | ArrayObject::STD_PROP_LIST);
    }

    /**
     * @return boolean;
     */
    public function isDeleted() {
        return $this->getFlagsField()->flagEnabled(self::FLAG_DELETED);
    }

    /**
     * @param boolean $deleted
     * @return \org\majkel\dbase\Record
     */
    public function setDeleted($deleted) {
        $this->getFlagsField()->enableFlag(self::FLAG_DELETED, $deleted);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->getArrayCopy();
    }

    /**
     * @param string $name
     * @return integer|null
     */
    public function getMemoEntryId($name) {
        return isset($this->memoEntries[$name]) ? $this->memoEntries[$name] : null;
    }

    /**
     * @param string $name
     * @param integer $entryId
     */
    public function setMemoEntryId($name, $entryId) {
        $this->memoEntries[$name] = (integer) $entryId;
    }
}
