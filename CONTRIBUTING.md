# Contribution Guidelines

## Code Style

The source of this application follows PSR-2 code style with a few exceptions.

### Inverting Conditionals

Parens and other vertical marks can look similar. Consequently, we pad the `!` operator with spaces to reduce cognitive overhead.

**PSR-2**

    if (!$value) {

**LIO**

    if ( ! $value) {

### Interface Naming

Interfaces define a role and thus the name should reflect the role that is defined.

**PSR-2**

    interface PostCreatorObserverInterface

**LIO**

    interface PostCreatorObserver
