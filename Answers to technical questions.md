### Answers To Technical Questions

1. How long did you spend on the coding test? What would you add to your solution if you had more time?

Time Take:  **5 hours**

* I would have extracted the serialization of the entities, out into separate serialization class. Making it easier to
manage and maintain them in the long run.
* Added validation to the endpoints. At the moment they don't provide useful responses if incorrect values are provided.
* I would have liked to have implemented shift breaks, and take them into account when calculating the single manning time.
* Would have like to improve the ui to show the single manned time
* Implement vue, but that would have require quite a bit of extra time.
* Implemented some static analysis to help catch basic coding issues
* Setup a simple CI pipeline, to make sure that my tests succeed automatically

2. Why did you choose PHP as your main programming language?
* Its the language that is used by the majority of the internet.
* Is a mature language, with a lot of support and documentation online.
* The PHP group has been dedicated to php improvement in the last few years, and with PHP7 they got rid of a lot of issues.
Making me excited to work with it.

3. What is your favourite thing about your most familar PHP framework (Laravel / Symfony etc)? 
* Like php it is a mature framework, there are plenty of forums and discussions on how to use.
* Has a large selection of bundles which can be used to speed up development.
* Maker bundle makes the creation of classes and tests very simple.
* Symfony doctrine makes the creations of databases a walk in the park, by generating migrations to match its entities. 

4. What is your least favourite thing about the above framework?
* When setting up projects symfony can be quite assumptive about what you want. Requiring some extra time to fix the configs.
* Autowiring can extract a little bit too much away from a developer, making it harder to figure out how something works.

### Scenario

#### Four
```
Wolverine: |----------|
Gamora:                    |---------|
```

__Given__ Wolverine and Gamora working at FunHouse on Thursday

__When__ Wolverine works in the morning shift

__And__ Gamora works the evening

__And__ The shop closes for an hour over lunch when no one is working

__Then__ Wolverine and Gamora receives single manning supplement 

#### Five
```
Black Widow: |----------------------|
Gamora:      |---------|
Thor:                       |-------|
```

__Given__ Black Widow, Gamora and Thor are working at FunHouse on Friday

__When__ Blackwidow works all day

__And__ Gamora works the morning shift

__And__ Thor works the closing shift

__And__ There is a gap over lunch betten the morning and closing shift

__Then__ Only Black Widow gets single manning supplement for the time over lunch when neither Thor or Gamora are in