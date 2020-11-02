<?php
class ApplicationDocumentShell extends AppShell {
    public $uses = ['ApplicationDocument', 'Event'];

	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser
			->addSubcommand('delete', [
				'help' => 'Soft delete one or more application documents, combine with "prune" for permanent deletion.',
				'parser' => [
					'arguments' => [
                        'scope' => [
                            'help' => 'Soft-delete all from "event", one individual "document"',
                            'choices' => ['event', 'document'],
                            'required' => true
                        ],
						'id' => ['help' => 'The id of event or document to delete', 'required' => false],
                    ]
                ]
            ])
            ->addSubcommand('prune', [
                'help' => 'Permanently delete all soft-deleted applications',
            ])
            ->addSubcommand('statistics', [
                'help' => 'Show general application document statistics',
            ]);
		return $parser;
	}

	public function statistics() {
        $documents = $this->ApplicationDocument->query("SELECT COUNT(*) as count, event_id, name FROM wb4_application_documents JOIN wb4_events ON wb4_application_documents.event_id = wb4_events.id GROUP BY event_id");

        $statistics = [
            ['Event name', 'Event id', 'Applications'],
            ...array_map(function($event_stats) {
                return [
                    $event_stats['wb4_events']['name'],
                    $event_stats['wb4_application_documents']['event_id'],
                    $event_stats[0]['count'],
                ];
            }, $documents),
        ];

        $this->helper('table')->output($statistics);
	}

    public function prune() {
        $documents = $this->ApplicationDocument->query("SELECT COUNT(*) as count, event_id, name FROM wb4_application_documents JOIN wb4_events ON wb4_application_documents.event_id = wb4_events.id WHERE NOT wb4_application_documents.deleted OR wb4_application_documents.deleted != '0000-00-00 00:00:00' GROUP BY event_id");

        $this->out('Found these soft-deleted applications available for permanent deletion.');

        $statistics = [
            ['Event name', 'Event id', 'Applications'],
            ...array_map(function($event_stats) {
                return [
                    $event_stats['wb4_events']['name'],
                    $event_stats['wb4_application_documents']['event_id'],
                    $event_stats[0]['count'],
                ];
            }, $documents),
        ];

        $this->helper('table')->output($statistics);

        $confirm = $this->in('Proceeding will PERMANENTLY delete all documents listed above! This can NOT be undone. Are you sure?', ['Y', 'N'], 'N');

        if ($confirm != 'Y') {
            $this->out("<error>Deletion aborted!</error>");
            return;
        }

        $this->hr();
        $this->out('Permanently deleting soft-deleted applications');

        if ($this->ApplicationDocument->deleteAll([
            'ApplicationDocument.deleted !=' => '0000-00-00 00:00:00',
            'ApplicationDocument.deleted !=' => null,
        ])) {
            $this->out('<success>Permanent deletions done</success>');
        } else {
            $this->out('<error>Error during permanent deletion</error>');
        }

        $this->hr();
        $this->out('<info>Applications left after pruning:</info>');
        $this->statistics();
    }

    public function delete() {
        switch ($this->args[0]) {
        case 'event':
            return $this->deleteByEvent($this->args[1]);
            break;
        case 'document':
            return $this->deleteByDocument($this->args[1]);
            break;
        }
    }

    private function deleteByEvent($id) {
        $event = $this->Event->findById($id);
		if (empty($event)) {
			$this->out('<error>Event id not found. Valid events include:</error>');
            $this->statistics();
			return;
		}

        $event_string = $event['Event']['name'] .' (id: '. $event['Event']['id'] .')';

        $confirm = $this->in('This will soft-delete all applications for '. $event_string .'. Are you sure?', ['Y', 'N'], 'N');

        if ($confirm != 'Y') {
            $this->out("<error>Soft-deletion aborted!</error>");
            return;
        }

        $deletion_date = date('Y-m-d H:i:s');
        $this->hr();
        $this->out('Soft-deleting all applications for '. $event_string);

        if ($this->ApplicationDocument->updateAll(
            ['ApplicationDocument.deleted' => "'$deletion_date'"],
            ['ApplicationDocument.event_id' => $event['Event']['id']]
        )) {
            $this->out('<success>All applications for '. $event_string .' has been soft-deleted.</success>');
        } else {
            $this->out('<error>Error while trying to soft-delete applications for '. $event_string .'</error>');
        }

        $this->hr();
        $this->out('<warning>To permanently delete soft-deleted applications run "prune" command</warning>');
    }

    private function deleteByDocument($id) {
        $document = $this->ApplicationDocument->findById($id);
		if (empty($document)) {
			$this->out('<error>Document id not found.</error>');
			return;
		}

        $confirm = $this->in('This will soft-delete application'. $document['ApplicationDocument']['id'] .'. Are you sure?', ['Y', 'N'], 'N');

        if ($confirm != 'Y') {
            $this->out("<error>Soft-deletion aborted!</error>");
            return;
        }

        $this->hr();
        $this->ApplicationDocument->id = $document['ApplicationDocument']['id'];

        if ($this->ApplicationDocument->saveField('deleted', date('Y-m-d H:i:s'))) {
            $this->out('<success>Application '. $this->ApplicationDocument->id .' has been soft-deleted.</success>');
        } else {
            $this->out('<error>Error while trying to soft-delete application '. $this->ApplicationDocument->id .'</error>');
        }

        $this->hr();
        $this->out('<warning>To permanently delete all soft-deleted applications run "prune" command</warning>');
    }

}
