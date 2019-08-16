<?php

class LogisticStatus extends LogisticAppModel {
    public $name = 'LogisticStatus';
    public $displayField = 'canonicalname';

    // These constants are only a convenience for referring to the statuses
    // defined in the wb4_logistic_statuses table in the database. Ideally, the
    // definitions of these statuses should be moved out of the database
    // entirely.
    public $REGISTERED   = 1;
    public $IN_TRANSIT   = 2;
    public $ARRIVED      = 3;
    public $CHECKED_OUT  = 4;
    public $CHECKED_IN   = 5;
    public $RETURNED     = 6;
    public $MOVED        = 7;
    public $UNREGISTERED = 8;
    public $REREGISTERED = 9;
}
