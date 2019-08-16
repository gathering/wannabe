<?

class LogisticBulk extends LogisticAppModel {
    public $name = 'LogisticBulk';
    public $belongsTo = array('LogisticSupplier' =>
        array('className' => 'LogisticSupplier')
    );

    public function setDeleted($id) {
        $bulkdata['LogisticBulk']['id'] = $id;
        $bulkdata['LogisticBulk']['amount'] = 0;
        $bulkdata['LogisticBulk']['amountleft'] = 0;
        $bulkdata['LogisticBulk']['deleted'] = date('Y-m-d H:i:s');
        $this->save($bulkdata);
    }

    public function unDelete($id, $amount = 0) {
        $bulkdata['LogisticBulk']['id'] = $id;
        $bulkdata['LogisticBulk']['amount'] = $amount;
        $bulkdata['LogisticBulk']['amountleft'] = 0;
        $bulkdata['LogisticBulk']['deleted'] = NULL;
        $this->save($bulkdata);
    }

    public function getAmountsPerStorage($item, $bulk) {
        // Summarize the amounts available at each storage location by
        // iterating over all transactions in chronological order
        $status = ClassRegistry::init('Logistic.LogisticStatus');
        $storage_amounts = array();
        foreach (array_reverse($item['LogisticTransaction']) as $transaction) {
            if (in_array($transaction['LogisticTransaction']['logistic_status_id'], array(
                    $status->REGISTERED, $status->UNREGISTERED, $status->REREGISTERED))) {
                /* Reset all storage amounts. */
                $storage_amounts = array();
                continue;
            }
            $storage_id = $transaction['LogisticTransaction']['logistic_storage_id'];
            $prev_storage_id = $transaction['LogisticTransaction']['prev_logistic_storage_id'];
            $storage_amount = (array_key_exists($storage_id, $storage_amounts) ? $storage_amounts[$storage_id] : 0);
            $prev_storage_amount = (array_key_exists($prev_storage_id, $storage_amounts) ? $storage_amounts[$prev_storage_id] : 0);

            $transaction_amount = $transaction['LogisticTransaction']['amount'];

            // Update the amount available at the current storage location,
            // according to the logic in LogisticTransactionController::apply()
            switch ($transaction['LogisticTransaction']['logistic_status_id']) {
            case $status->ARRIVED:      $storage_amount  = $transaction_amount; break;
            case $status->CHECKED_OUT:  $storage_amount -= $transaction_amount; break;
            case $status->CHECKED_IN:   $storage_amount += $transaction_amount; break;
            case $status->RETURNED:     $storage_amount  = 0; break;

            case $status->MOVED:
                $storage_amount += $transaction_amount;
                $prev_storage_amount -= $transaction_amount;
                break;
            }

            if ($storage_amount != 0) {
                $storage_amounts[$storage_id] = $storage_amount;
            } else {
                unset($storage_amounts[$storage_id]);
            }
            if ($prev_storage_amount != 0) {
                $storage_amounts[$prev_storage_id] = $prev_storage_amount;
            } else {
                unset($storage_amounts[$prev_storage_id]);
            }
        }
        return $storage_amounts;
    }
}
