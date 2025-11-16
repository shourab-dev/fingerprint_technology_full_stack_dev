## 1. Which parts you used AI assistance for (Claude Code/Cursor/ChatGPT)

I have used claude ai with Co-pilot to assist me with the code. To be very honest I have hands on experience on React and Next JS but I didn't do any real life projects with Vue js.
It will probably take a week for me to adapt with the vue environment, most of the principal are the same. So, I have use Claude to generate most my Vue.js staff. The frontend design is mostly generated with vue. But I used Co-pilot along with claude to understand how vue components work. How ref works like useState in React. How to state management using pinia. So, using both of the both I have learned the basic fundamentals and deployed the Vue JS Frontend.

## 2. 3 specific prompts you used and how they helped

When it's time for the prompt I make sure to give a specific promot as possible to get better result.
So, The first prompt was
"We have a functioning StudentList.vue component (src/views/StudentList.vue) that
displays students with search, filtering, and pagination. The component works
correctly but I need a professional code review to identify:

-   Potential performance bottlenecks
-   Code quality issues
-   Best practice violations
-   Security concerns
-   Accessibility gaps

Scope of Review:
File: src/views/StudentList.vue (lines 1-350)

Specific Areas to Analyze:

1. Performance:

    - Are there unnecessary re-renders?
    - Is the computed properties optimization correct?
    - Are watchers being used efficiently?
    - Is the pagination logic optimal for large datasets?
    - Any memory leaks in event listeners or intervals?

2. Code Quality:

    - Is the component following Vue 3 Composition API best practices?
    - Are ref/reactive being used correctly?
    - Is there proper error handling?
    - Are the methods too long or doing too much?
    - Can any code be extracted into composables?

3. State Management:

    - Is Pinia being used correctly?
    - Are we storing the right data in the store vs component state?
    - Are there unnecessary store subscriptions?
    - Is cache invalidation handled properly?

4. Accessibility:
    - Are ARIA labels present and correct?
    - Is keyboard navigation working?
    - Are focus states visible?
    - Is screen reader support adequate?"

"Review my Dashboard.vue component and tell me:

1. What are the 3 biggest problems with this code?
2. Is there anything that could cause performance issues?
3. Are there any security concerns?

Keep it brief - just the main issues with code examples showing
what's wrong and how to fix it."

"Check my authentication API endpoints for security issues:

Files:

-   app/Http/Controllers/Api/AuthController.php
-   routes/api.php (auth routes)
-   app/Models/User.php

Questions:

1. Can anyone access these endpoints without authentication?
2. Is the password hashing secure?
3. Are tokens being created/deleted correctly?
4. Any SQL injection risks?
5. Is the logout working properly?

Just give me a simple list of issues found (if any) with line numbers."

## 3. How AI improved your development speed

AI definately increase my productivity 100x. Sometimes the basic staff can be handled by AI, just need to write down some logics from human side. In my Opinion this project might took me more than just a day or two If I starting building it without AI. But if utilize AI properly, you can build Apps faster. But with every power there comes a great responsibility. Sometimes AI
Messed things up. So, It's a good practice to test throughly every part of the application.

## 4. What you manually coded vs AI-generated

Alhamdurilla I am good understanding about Laravel eco-system along side Next JS. But I am honestly speaking did not create any hands on project using vue. I have learned vue back in 2020, but after that Composition API come with a lot of changes. And my currently running projects requires to work with Next-JS and React. So, the Vue part is almost generated with AI. I have written the Laravel Rest API part. But the test case was written by AI.
