# Sweetwater Coding Test

While more familiar with CakePHP and Symphony, Larvel is always a treat to experience. This was the first app I had set up
from scratch with Laravel so there was a tiny bit of learning I had to do, but nothing that wasn't fairly familiar.

## My solution

I took a similar approach to my raw PHP solution for most of this project while leveraging more of Laravel's framework
advantages, like DB connectivity, ORM, and templating methodology.

### Data structures
I first built a model to represent the SQL object provided in the materials. This would allow me to easily access the
records and their attributes for display and manipulation. Within the model, I establish constants as common information
that I'll use across the app. Additionally, I set the `$timestamps` property to false so that updates, like fixing the expected
ship date, don't attempt to manipulate an `updated_at` field. Finally, to solve for the categories, I added a virtual
attribute that would attach to each record. While not elegant, the quickest approach I could think of was to find common
words associated with each category and use regular expression matching to search the comment body. If these matches were
found, I assign a category ID. Since each comment could only belong to one category in this test, I decided to give priority
to each category based on the order given in the material.

### Control structures
The control layer here is fairly simple, though it does include the logic for fixing the expected ship dates. The main
action for this controller is the `show` action. This initially calls the date fix method and then delivers the view.
Nothing overly complex here. The meat of this code is in the date fix method. Since the Eloquent ORM allows for bulk
updates, as well as raw SQL, I felt the best course would be to let MySQL do the heavy lifting here. MySQL can reference
its own data, parse for strings, return subsets of information, and update columns within the same record. Doesn't that
within PHP can be expensive. The code written takes function over form approach by leveraging the raw DB method extended
by Illuminate to call a chunk bit of SQL code to find the date based upon the `Expected Ship Date: ` anchor point. The
PHP function here is far from elegant. Had I given it more time or thought, I would build a mechanism that would be aware
of if this function had been previously run and saved cycles by not kicking off the update statement. The return could be
more graceful as well to allow the calling method to be aware of its success or failure and take some ultimate action,
but due to the nature of the test, I didn't feel it worth spending energy on.

### View Structures
Fairly simple application here as well. The most interesting bit would be the logic surrounding the display of the
category name. I really enjoy template structures and Blade works really well. For the bulk of this view logic, I
relied on the foreach loop. In each iteration, I checked the incoming record's category against the current category
heading to determine when to switch. Pairing that logic with a sort on the return of records is a quick and dirty solution
to keep these records in their respective view categories, though a more robust approach would be better. While the
instructions didn't say to display the Order ID or Expected Shipping Date, I decided to add each to the displayed object
just for ease of viewing and searching for various comments.