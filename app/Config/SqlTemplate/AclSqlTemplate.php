<?php
/* SQL tempate for ACL */
class AclSqlTemplate {
	var $template = array(
		array(
			'path-template' => '/:event/',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Accreditation/',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Accreditation/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Accreditation/Group*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Accreditation/Register/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Admin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/api/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Application/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/ApplicationAdmin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/ApplicationManager/Greeting/*',
			'roles' => array(
				'chief' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/ApplicationManager/Question/*',
			'roles' => array(
				'co-chief' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Carplate/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/CarplateAdmin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Crew/',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Crew/*',
			'roles' => array(
				'shiftleader' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				),
				'co-chief' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Crew/Cleanup/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Crew/Description/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Crew/Description/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				),
				'member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Crew/Edit/*',
			'roles' => array(
				'organizer' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 1,
					'superuser' => 0
				),
				'co-chief' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				),
				'shiftleader' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Crew/Edit/Core',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Crew/View/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Crew/viewTaskStatus/*',
			'roles' => array(
				'shiftleader' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/CrewEffectsItem/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/CrewEffectsOrder/',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/CrewEffectsOrder/economy/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/CrewEffectsOrder/logistics/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/CrewEffectsOrder/overview/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Daypass/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Dispatch/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Enroll/*',
			'roles' => array(
				'co-chief' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 1,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/EnrollAdmin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Event/change/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/EventAdmin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Geocode/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Home/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/IrcChannelKeyAdmin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/KanduMembership/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Logistic*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/LostAndFound/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/MailingList/',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Mealtime/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Mealtime/view/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Message/compose/from:2*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Message/send/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Needs/',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/NeedsAdmin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/NeedsAdmin/deny/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/NeedsAdmin/medical/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/NeedsAdmin/nutritional/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Privacy/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Profile/',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Profile/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Profile/Edit/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Profile/Email/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Profile/Password/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Profile/Picture/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Profile/View/',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Search/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/ShowupTimes/',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/ShowupTimes/moderate/',
			'roles' => array(
				'co-chief' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 1,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/ShowupTimes/view/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/SleepingPlaces/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Slideshow/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Slideshow/getSlideShow/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Slideshow/RunSlideshow/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/SmsMessage/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/SmsMessage/cleanups/',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Task/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Term/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/User/Logout/*',
			'roles' => array(
				'non-member' => array(
					'read' => 1,
					'write' => 0,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/UserPref/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Vote/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/Vote/Result/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		),
		array(
			'path-template' => '/:event/WardrobeCard/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/WardrobeCardAdmin/*',
			'roles' => array()
		),
		array(
			'path-template' => '/:event/Wiki/*',
			'roles' => array(
				'member' => array(
					'read' => 1,
					'write' => 1,
					'manage' => 0,
					'superuser' => 0
				)
			)
		)
	);
}
