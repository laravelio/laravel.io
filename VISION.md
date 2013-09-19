# Vision Document

**Dear Team,**

I have built this document using absolutes in language. This document is intended to be authoritative. That doesn’t mean that the data contained within is intended to be final. To the contrary, I have built this document to give us a place to formalize and evolve our thoughts. The content contained within defines the initial launch of the Laravel.IO site. I have decided to put 30 minutes per day into the application, and the work that you’ve seen from me over the past 3 days has been the result of this discipline. I hope that you too will find a schedule that enables this application to be built and maintained.

We have the opportunity to create a somewhat unprecedented system. A system that is designed solely to enable our community. As software designers, engineers and architects, we have within our power the capacity to create something truly remarkable. I hope that each of us can take this idea to heart and build something that we’re truly proud of.

## Project Standards
1. We are fully compliant with PSR-2, allowing for the deviation of a single space before a ! operator within conditionals.
2. Namespacing is done with use-cases with Lio as the top-level namespace. For Example: Lio\Accounts\User would be preferred to Lio\User or Lio\Users\User or Lio\Models\User.
3. The application is built upon PHP 5.4 and at all times 5.4 structures should be favored over the structures used in 5.3 and below.

## Requirements

### Tags

Tags are a carefully curated list determined by the Laravel.IO team. These should not be added dynamically without discussion. Tags must be finite and maintainable as they directly influence the efficacy of the tagging system.

Examples of tags that I believe are relevant:

1. Installation / Configuration
2. Authentication / Security
3. Requests / Input
4. Session / Cache
5. Architecture / IoC
6. Database / Eloquent
7. Views / Forms
8. Queues / Mail

These are pretty much pulled straight from the documentation. [http://laravel.com/docs](http://laravel.com/docs)

### Comments

Comments are unified across the entire site. Comments are powered by an internal comment system driven by polymorphic relationships. Comments are used on pastes, articles and as a core building block of the forum.

### Forum

The new forum is a simplified and custom built forum that utilizes ForumCategory models which relate to Comment models.

### Pastebin Use
1. user navigates to laravel.io/bin (to be replaced with a subdomain, later)
2. user pastes their code
3. user presses a button that stores their snippet to the server and creates a link
4. user shares the link with other users, so that they can view the code
5. other users can click the link to see the code
6. any user can fork a snippet and be given their own unique link
7. any authenticated user can add comments to any snippet
8. each snippet page provides a way to see snippets that have been forked from it
9. each snippet page provides a way to see the comments added to it

### Pastebin Retention
Pastes created by users who are not authenticated will live for 48 hours. Authenticated users will have the option to store their pastes permanently, or for shorter periods of time. Pastebin cleanup will be handled using a lottery algorithm.

Special care must be taken when removing pastes that have forked children. The algorithm for this should be to turn the children into parent pastes first, then removing the parent once it has no children.

### Pastebin Hashing
The Pastebin is not considered to be a secure way to store data. I see no reason to attempt to make it such. The hashids library should probably be used for this.

### User Profile Page

Every authenticated user will have a profile page. This page shows any articles that the user has made and can double as a blog page for that user.

### Articles

All authenticated users have the ability to create their own articles. These articles can be tagged. The tagged articles can be viewed at the user's profile page.

### Article Use
1. user navigates to the articles section of the site
2. user is presented with a list of articles that can be sorted by popularity or recentness. each article is summarized and shows small thumbnails of the images that have been attached to the article by the author. If a video is present within the article, it is indicated here. If audio is present within the article, it is indicated here. All article lists are paginated.
3. user can choose a tag from a side-menu
4. the tag view continues to show the same side-menu with an active state on the selected tag, the content of the page shows a list of articles that can be sorted by popularity or recentness

### Site-wide Slug Policy
Slugs should be unified site-wide and presented with reasonable URLs. An example of a good slug might be: http://laravel.io/post/the-art-of-eating-cats-and-dogs_Mitchell-van-Wijngaarden

### Site-wide Spam-prevention
As with all public-facing Laravel.io forms, spam-prevention will be handled using the honeypot technique. A text input field hidden with css should be named something that is generally required, such as password. Password is the preferred choice. On submit, the password field must be checked for emptiness. If it’s not empty, then the request can be safely discarded. The request should be discarded in a way that doesn’t fire off an http status code that indicates to bots that an error occurred.


