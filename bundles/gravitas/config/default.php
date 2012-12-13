<?php

/**
 * Gravatar configuration
 */

return array(
	
    // ======================================================================
	// Size
	// ======================================================================
	// By default, images are presented at 80px by 80px if no size parameter
	// is supplied. You may request a specific image size, which will be
	// dynamically delivered from Gravatar by using the s= or size= parameter
	// and passing a single pixel dimension (since the images are square):
	// 
	// http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200
	// 
	// You may request images anywhere from 1px up to 512px, however note that
	// many users have lower resolution images, so requesting larger sizes may
	// result in pixelation/low-quality images.
	// ======================================================================
	'size' => 80,

	// ======================================================================
	// Default Image
	// ======================================================================
	// If you'd prefer to use your own default image (perhaps your logo, a
	// funny face, whatever), then you can easily do so by supplying the URL
	// to an image here.
	// 
	// When you include a default image, Gravatar will automatically serve up
	// that image if there is no image associated with the requested email.
	// 
	// In addition to allowing you to use your own image, Gravatar has a
	// number of built in options which you can also use as defaults. Most of
	// these work by taking the requested email hash and using it to generate
	// a themed image that is unique to that email address:
	// 
    // * 404: do not load any image if none is associated with the email hash,
	//   instead return an HTTP 404 (File Not Found) response
	// * mm: (mystery-man) a simple, cartoon-style silhouetted outline of a
	//   person (does not vary by email hash)
	// * identicon: a geometric pattern based on an email hash
	// * monsterid: a generated 'monster' with different colors, faces, etc
	// * wavatar: generated faces with differing features and backgrounds
	// * retro: awesome generated, 8-bit arcade-style pixelated faces
	// ======================================================================
	'default_image' => false,

	// ======================================================================
	// Rating
	// ======================================================================
	// Gravatar allows users to self-rate their images so that they can
	// indicate if an image is appropriate for a certain audience. By default,
	// only 'G' rated images are displayed unless you indicate that you would
	// like to see higher ratings. You may specify one of the following
	// ratings to request images up to and including that rating:
	// 
	// * g: suitable for display on all websites with any audience type.
	// * pg: may contain rude gestures, provocatively dressed individuals, the
	//   lesser swear words, or mild violence.
	// * r: may contain such things as harsh profanity, intense violence,
	//   nudity, or hard drug use.
	// * x: may contain hardcore sexual imagery or extremely disturbing
	//   violence.
	// 
	// If the requested email hash does not have an image meeting the
	// requested rating level, then the default image is returned (or the
	// specified default, as per above)
	// ======================================================================
	'rating' => 'g',

	// ======================================================================
	// Secure Requests
	// ======================================================================
	// If you're displaying Gravatars on a page that is being served over SSL
	// (e.g. the page URL starts with HTTPS), then you'll want to serve your
	// Gravatars via SSL as well, otherwise you'll get annoying security
	// warnings in most browsers.
 	// ======================================================================
 	'secure' => Request::secure(),

);