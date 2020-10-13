<?php

echo mk_get_shortcode_view(
	'mk_contact_form', 'components/name-field', true, array(
		'tab_index' => $view_params['id']++,
		'phone' => $view_params['phone'],
	)
);

if ( 'true' == $view_params['phone'] ) {
	echo mk_get_shortcode_view(
		'mk_contact_form', 'components/phone-field', true, array(
			'tab_index' => $view_params['id']++,
			'phone' => $view_params['phone'],
		)
	);
}

echo mk_get_shortcode_view(
	'mk_contact_form', 'components/email-field', true, array(
		'tab_index' => $view_params['id']++,
		'phone' => $view_params['phone'],
	)
);

echo mk_get_shortcode_view(
	'mk_contact_form', 'components/message-field', true, array(
		'tab_index' => $view_params['id']++,
	)
);

if ( 'true' == $view_params['captcha'] ) {
	echo mk_get_shortcode_view(
		'mk_contact_form', 'components/captcha-field', true, array(
			'tab_index' => $view_params['id']++,
		)
	);
}

if ( 'true' == $view_params['gdpr_consent'] ) {
	echo mk_get_shortcode_view(
		'mk_contact_form', 'components/gdpr-consent', true, array(
			'gdpr_consent_text' => $view_params['gdpr_consent_text'],
			'tab_index' => $view_params['id']++,
		)
	);
}

$button_class = 'mk-progress-button contact-outline-submit outline-btn-' . $view_params['skin'];

echo mk_get_shortcode_view(
	'mk_contact_form', 'components/button', true, array(
		'tab_index' => $view_params['id']++,
		'button_text' => $view_params['button_text'],
		'button_class' => $button_class,
	)
);

echo mk_get_shortcode_view(
	'mk_contact_form', 'components/security', true, array(
		'id' => $view_params['id'],
		'email' => $view_params['email'],
	)
);

