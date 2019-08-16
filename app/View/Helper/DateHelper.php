<?

class DateHelper extends AppHelper {

        /**
         * Checks if we are past a date in mysql-form.
         *
         * @param string $date
         * @return boolean
         */
        public function isPastDue($date)
        {
                return( $date and strtotime($date) <= time() and ( $date != '0000-00-00 00:00:00' ) );
        }
}

?>
