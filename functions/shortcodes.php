<?php
add_shortcode("sphere_participants", 'sphere_participants');
add_shortcode("sphere_report_participants", 'sphere_report_participants');
add_shortcode("sphere_participantId", "sphere_participant_id");
add_shortcode("sphere_teams", 'sphere_teams');
add_shortcode("sphere_report_teams", 'sphere_report_teams');
add_shortcode("sphere_teamId", "sphere_team_id");
add_shortcode("sphere_donate", "sphere_donate");
add_shortcode("sphere_register", "sphere_register");
add_shortcode("sphere_eventId", "sphere_event_id");
add_shortcode("sphere_eventName", "sphere_event_name");
add_shortcode("sphere_eventGoal", "sphere_event_goal");
add_shortcode("sphere_eventRaised", "sphere_event_raised");
add_shortcode("sphere_participantsSearch", "sphere_participants_search");
add_shortcode("sphere_teamSearch", "sphere_team_search");
add_shortcode("sphere_teamCount", "sphere_team_count");
add_shortcode("sphere_participantCount", "sphere_participant_count");
add_shortcode('sphere_search', 'sphere_search_cb');
function sphere_participants($atts) {
	extract(shortcode_atts(array(
		'amount' => 0,
		'show_amount_raised' => 0,
		'whole_amounts' => 0,
		'show_commas' => 0,
	), $atts));
	$participants = sphere_get_participants(array(
		'amount' => $amount,
	));
	ob_start();
	?>
	<?php if (!empty($participants)) : ?>
	<dl class="top-participants">
		<?php foreach ($participants as $participant) : ?>
		<?php 
			if ($whole_amounts) {
				if ($show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 0, '', ',');
				if (!$show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 0, '', '');
			} else {
				if ($show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 2, '.', ',');
				if (!$show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 2, '.', '');
			}
		?>
			<dt><?php echo $show_amount_raised ? "$" . $participant->amount_raised_pending . " - " : ''; ?></dt>
			<dd><a href="http://www.kintera.org/faf/donorReg/donorPledge.asp?ievent=<?php echo $participant->event_id; ?>&supId=<?php echo $participant->supporter_id; ?>"><?php echo $participant->fname; ?> <?php echo $participant->lname; ?></a></dd>
		<?php endforeach; ?>
	</dl>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}
function sphere_report_participants($atts) {
	extract(shortcode_atts(array(
		'report' => '',
		'amount' => 0,
		'show_amount_raised' => 0,
		'whole_amounts' => 0,
		'show_commas' => 0,
	), $atts));
	$participants = sphere_get_participants(array(
		'amount' => $amount,
		'type' => $report,
	));
	ob_start();
	?>
	<?php if (!empty($participants)) : ?>
	<dl class="<?php echo sphere_slug($report); ?>-top-participants">
		<?php foreach ($participants as $participant) : ?>
		<?php 
			if ($whole_amounts) {
				if ($show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 0, '', ',');
				if (!$show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 0, '', '');
			} else {
				if ($show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 2, '.', ',');
				if (!$show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 2, '.', '');
			}
		?>
			<dt><?php echo $show_amount_raised ? "$" . $participant->amount_raised_pending . " - " : ''; ?></dt>
			<dd><a href="http://www.kintera.org/faf/donorReg/donorPledge.asp?ievent=<?php echo $participant->event_id; ?>&supId=<?php echo $participant->supporter_id; ?>"><?php echo $participant->fname; ?> <?php echo $participant->lname; ?></a></dd>
		<?php endforeach; ?>
	</dl>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}
function sphere_participant_id($atts) {
	extract(shortcode_atts(array(
		'id' => 0,
		'show_amount_raised' => 0,
		'whole_amounts' => 0,
		'show_commas' => 0,
	), $atts));
	$participants = sphere_get_participants(array(
		'supporter_id' => $id,
	));
	ob_start();
	?>
	<?php if (!empty($participants)) : ?>
		<?php foreach ($participants as $participant) : ?>
		<?php 
			if ($whole_amounts) {
				if ($show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 0, '', ',');
				if (!$show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 0, '', '');
			} else {
				if ($show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 2, '.', ',');
				if (!$show_commas) $participant->amount_raised_pending = number_format($participant->amount_raised_pending, 2, '.', '');
			}
		?>
			<a href="http://www.kintera.org/faf/donorReg/donorPledge.asp?ievent=<?php echo $participant->event_id; ?>&supId=<?php echo $participant->supporter_id; ?>"><?php echo $show_amount_raised ? "$" . $participant->amount_raised_pending . " - " : ''; ?><?php echo $participant->fname; ?> <?php echo $participant->lname; ?></a>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}
function sphere_teams($atts) {
	extract(shortcode_atts(array(
		'amount' => 0,
		'show_amount_raised' => 0,
		'whole_amounts' => 0,
		'show_commas' => 0,
	), $atts));
	
	if (sphere_team_report_only()): 
		$participants = sphere_get_teams_report_only(array(
			'is_team' => 'Y',
			'amount' => $amount,
		));
	else:
		$participants = sphere_get_teams(array(
			'is_team' => 'Y',
			'amount' => $amount,
		));
	endif;
	
	ob_start();
	?>
	<?php if (!empty($participants)) : ?>
	<dl class="top-teams">
		<?php foreach ($participants as $participant) : ?>
		<?php 
			if ($whole_amounts) {
				if ($show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 0, '', ',');
				if (!$show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 0, '', '');
			} else {
				if ($show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 2, '.', ',');
				if (!$show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 2, '.', '');
			}
		?>
			<dt><?php echo $show_amount_raised ? "$" . $participant->team_amount_raised_pending . " - " : ''; ?></dt>
			<dd><a href="http://theprouty.kintera.org/faf/search/searchTeamPart.asp?ievent=<?php echo $participant->event_id; ?>&lis=1&team=<?php echo $participant->team_id; ?>"><?php echo $participant->team_name; ?></a></dd>
		<?php endforeach; ?>
	</dl>
	<?php endif; ?>	
	<?php
	return ob_get_clean();
}
function sphere_report_teams($atts) {
	extract(shortcode_atts(array(
		'report' => '',
		'amount' => 0,
		'show_amount_raised' => 0,
		'whole_amounts' => 0,
		'show_commas' => 0,
	), $atts));
	if (sphere_team_report_only()):
		$participants = sphere_get_teams_report_only(array(
			'is_team' => 'Y',
			'amount' => $amount,
			'type' => $report,
		));
	else:
		$participants = sphere_get_teams(array(
			'is_team' => 'Y',
			'amount' => $amount,
			'type' => $report,
		));
	endif; 
	
	ob_start();
	?>
	<?php if (!empty($participants)) : ?>
	<dl class="<?php echo sphere_slug($report); ?>-top-teams">
		<?php foreach ($participants as $participant) : ?>
		<?php 
			if ($whole_amounts) {
				if ($show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 0, '', ',');
				if (!$show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 0, '', '');
			} else {
				if ($show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 2, '.', ',');
				if (!$show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 2, '.', '');
			}
		?>
			<dt><?php echo $show_amount_raised ? "$" . $participant->team_amount_raised_pending . " - " : ''; ?></dt>
			<dd><a href="http://theprouty.kintera.org/faf/search/searchTeamPart.asp?ievent=<?php echo $participant->event_id; ?>&lis=1&team=<?php echo $participant->team_id; ?>"><?php echo $participant->team_name; ?></a></dd>
		<?php endforeach; ?>
	</dl>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}
function sphere_team_id($atts) {
	extract(shortcode_atts(array(
		'id' => 0,
		'show_amount_raised' => 0,
		'whole_amounts' => 0,
		'show_commas' => 0,
	), $atts));
	if (sphere_team_report_only()): 
		$participants = sphere_get_teams_report_only(array(
			'team_id' => $id,
		));
	else:
		$participants = sphere_get_teams(array(
			'team_id' => $id,
		));
	endif;
	
	ob_start();
	?>
	<?php if (!empty($participants)) : ?>
		<?php foreach ($participants as $participant) : ?>
		<?php 
			if ($whole_amounts) {
				if ($show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 0, '', ',');
				if (!$show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 0, '', '');
			} else {
				if ($show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 2, '.', ',');
				if (!$show_commas) $participant->team_amount_raised_pending = number_format($participant->team_amount_raised_pending, 2, '.', '');
			}
		?>
		<a href="http://theprouty.kintera.org/faf/search/searchTeamPart.asp?ievent=<?php echo $participant->event_id; ?>&lis=1&team=<?php echo $participant->team_id; ?>" class="team teamId<?php echo $participant->team_id; ?>"><?php echo $show_amount_raised ? "$" . $participant->team_amount_raised_pending . " - " : ''; ?><?php echo $participant->team_name; ?></a>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php
	return ob_get_clean();
}
function sphere_donate() {
	ob_start();
	?>
	<a href="https://www.kintera.org/faf/donorReg/donorPledge.asp?supId=0&ievent=<?php echo sphere_option('event_id'); ?>&lis=1&givenow=y" class="faf-donate">Donate</a>
	<?php
	return ob_get_clean();
}
function sphere_register() {
	ob_start();
	?>
	<a href="https://www.kintera.org/faf/r/default.asp?ievent=<?php echo sphere_option('event_id'); ?>&lis=1" class="faf-register">Register</a>
	<?php
	return ob_get_clean();
}
function sphere_event_id() {
	return sphere_option('event_id');
}
function sphere_event_name() {
	return sphere_get_event_name(sphere_option('event_id'));
}
function sphere_event_goal($atts) {
	extract(shortcode_atts(array(
		'whole_amounts' => 0,
		'show_commas' => 0
	), $atts));

	$event_goal = sphere_option('event_goal') ? sphere_option('event_goal') : sphere_get_goal(sphere_option('event_id'));

	if ($whole_amounts) {
		if ($show_commas) $event_goal = number_format($event_goal, 0, '', ',');
		if (!$show_commas) $event_goal = number_format($event_goal, 0, '', '');
	} else {
		if ($show_commas) $event_goal = number_format($event_goal, 2, '.', ',');
		if (!$show_commas) $event_goal = number_format($event_goal, 2, '.', '');
	}

	return $event_goal;
}
function sphere_event_raised($atts) {
	extract(shortcode_atts(array(
		'whole_amounts' => 0,
		'show_commas' => 0
	), $atts));

	$event_raised = sphere_option('event_raised') ? sphere_option('event_raised') : sphere_get_amount_raised(sphere_option('event_id'));

	if ($whole_amounts) {
		if ($show_commas) $event_raised = number_format($event_raised, 0, '', ',');
		if (!$show_commas) $event_raised = number_format($event_raised, 0, '', '');
	} else {
		if ($show_commas) $event_raised = number_format($event_raised, 2, '.', ',');
		if (!$show_commas) $event_raised = number_format($event_raised, 2, '.', '');
	}

	return $event_raised;
}
function sphere_participants_search() {
	ob_start();
	?>
	<a href="http://www.kintera.org/faf/search/searchParticipants.asp?ievent=<?php echo sphere_option('event_id'); ?>&lis=1" class="faf-participant-search">Participant Search &raquo;</a>
	<?php
	return ob_get_clean();
}
function sphere_team_search() {
	ob_start();
	?>
	<a href="http://theprouty.kintera.org/faf/search/searchTeam.asp?ievent=<?php echo sphere_option('event_id'); ?>&lis=1" class="faf-team-search">Team Search &raquo;</a>
	<?php
	return ob_get_clean();
}
function sphere_team_count($atts) {
	extract(shortcode_atts(array(
		'show_commas' => 0
	), $atts));
	global $wpdb;
	$teams = $wpdb->get_results("SELECT COUNT(DISTINCT team_id) as team_count FROM {$wpdb->prefix}teamsupporters");
	$team_count = $teams[0]->team_count;
	if ($show_commas) $team_count = number_format($team_count, 0, '', ',');
	return $team_count;
}

function sphere_participant_count($atts) {
	extract(shortcode_atts(array(
		'show_commas' => 0
	), $atts));
	global $wpdb;
	$participants = $wpdb->get_results("SELECT COUNT(DISTINCT supporter_id) as participant_count FROM {$wpdb->prefix}supporters");
	$participant_count = $participants[0]->participant_count;
	if ($show_commas) $participant_count = number_format($participant_count, 0, '', ',');
	return $participant_count;
}

function sphere_get_supporters($search, $limit = 10) {
	global $wpdb;
	$table = $wpdb->prefix . 'supporters';

	$sql_participant = $wpdb->prepare("SELECT * FROM $table WHERE lname LIKE %s OR fname LIKE %s ORDER BY id ASC LIMIT %d", "%{$search}%", "%{$search}%", $limit);
	$sql_team        = $wpdb->prepare("SELECT * FROM $table WHERE team_name LIKE %s ORDER BY id ASC LIMIT %d", "%{$search}%", $limit);

	$results['participants'] = $wpdb->get_results($sql_participant);
	$results['teams'] = $wpdb->get_results($sql_team);
	return $results;
}

function sphere_search_cb($atts, $content = null) {
	extract(shortcode_atts(array(
		'search' => '',
	), $atts));

	$results = sphere_get_supporters($search);

	ob_start();
	?>

	<div class="participant-list">
		<h2>Participants</h2>
		<ul class="participants">
			<?php if (is_array($results['participants']) && !empty($results['participants'])) : ?>
				<?php foreach ($results['participants'] as $participant) : ?>
					<li><a href="http://theprouty.kintera.org/faf/search/searchTeamPart.asp?ievent=<?php echo $participant->event_id; ?>&lis=1&team=<?php echo $participant->team_id; ?>"><?php echo $participant->fname . ' ' . $participant->lname ?></a></li>
				<?php endforeach ?>
			<?php else : ?>
				<li>No Participant Matches</li>
				<li><a href="#">Search for Participants</a></li>
			<?php endif; ?>
		</ul>
	</div>

	<div class="team-list">
		<h2>Teams</h2>
		<ul class="teams">
			<?php if (is_array($results['teams']) && !empty($results['teams'])) : ?>
				<?php foreach ($results['teams'] as $team) : ?>
					<li><a href="http://theprouty.kintera.org/faf/search/searchTeamPart.asp?ievent=<?php echo $team->event_id; ?>&lis=1&team=<?php echo $team->team_id; ?>"><?php echo $team->team_name; ?></a></li>
				<?php endforeach ?>
			<?php else : ?>
				<li>No Team Matches</li>
				<li><a href="#">Search for Teams</a></li>
			<?php endif; ?>
		</ul>
	</div>

	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
