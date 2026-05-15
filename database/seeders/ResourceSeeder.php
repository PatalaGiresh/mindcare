<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $articles = [
            [
                'title'     => 'Understanding Anxiety: What It Is and How to Manage It',
                'category'  => 'Anxiety',
                'excerpt'   => 'Anxiety is one of the most common mental health challenges. Learn practical strategies to identify triggers and manage symptoms effectively.',
                'body'      => '<p>Anxiety is a natural human response to stress and uncertainty. While occasional anxiety is normal, persistent anxiety can interfere with daily life and wellbeing.</p><h2>Common Signs of Anxiety</h2><ul><li>Racing thoughts and worry</li><li>Physical tension and restlessness</li><li>Difficulty sleeping</li><li>Avoiding situations that trigger anxiety</li></ul><h2>Evidence-Based Strategies</h2><p>Cognitive-behavioral therapy (CBT) has shown remarkable results in treating anxiety disorders. Key techniques include challenging negative thought patterns, gradual exposure therapy, and relaxation techniques like deep breathing and progressive muscle relaxation.</p><h2>When to Seek Help</h2><p>If anxiety is significantly affecting your quality of life, relationships, or work performance, it may be time to consult a mental health professional. Remember, seeking help is a sign of strength, not weakness.</p>',
                'read_time' => '5 min read',
            ],
            [
                'title'     => 'The Science of Mindfulness: How Meditation Changes Your Brain',
                'category'  => 'Mindfulness',
                'excerpt'   => 'Scientific research shows that regular mindfulness practice physically changes brain structure, improving emotional regulation and reducing stress.',
                'body'      => '<p>Mindfulness meditation has moved from ancient practice to modern science. Neuroimaging studies reveal that regular meditation actually changes the physical structure of the brain — a phenomenon called neuroplasticity.</p><h2>What the Research Shows</h2><p>Studies from Harvard Medical School and Oxford University have found that 8 weeks of mindfulness practice increases gray matter density in areas associated with emotional regulation, learning, and memory.</p><h2>Starting a Mindfulness Practice</h2><p>You don\'t need hours of meditation to see benefits. Research shows that even 10-15 minutes daily can produce measurable changes. Start with simple breath awareness exercises and gradually build your practice.</p><h2>Practical Mindfulness Exercises</h2><ul><li><strong>Box Breathing:</strong> Inhale 4 counts, hold 4, exhale 4, hold 4</li><li><strong>Body Scan:</strong> Progressively relax each body part</li><li><strong>Mindful Walking:</strong> Focus fully on each step and sensation</li></ul>',
                'read_time' => '7 min read',
            ],
            [
                'title'     => 'Breaking the Stigma: Starting Conversations About Mental Health',
                'category'  => 'Self-care',
                'excerpt'   => 'Mental health stigma prevents millions from seeking help. Here\'s how we can start meaningful conversations and build a more compassionate world.',
                'body'      => '<p>Despite growing awareness, mental health stigma remains one of the biggest barriers to seeking help. One in four people will experience a mental health issue in their lifetime, yet many suffer in silence due to fear of judgment.</p><h2>Understanding Stigma</h2><p>Stigma manifests in two main forms: social stigma (negative attitudes from others) and self-stigma (internalizing those negative beliefs). Both can be devastating and prevent people from accessing care they need and deserve.</p><h2>How to Have the Conversation</h2><ul><li>Choose a comfortable, private setting</li><li>Use "I" statements to express concern without judgment</li><li>Listen more than you speak</li><li>Avoid minimizing their experience</li><li>Offer practical support, not just advice</li></ul><h2>Resources and Support</h2><p>Remember that professional support is always available. Therapy, support groups, and crisis helplines provide confidential, judgment-free assistance.</p>',
                'read_time' => '6 min read',
            ],
            [
                'title'     => 'Sleep and Mental Health: The Bidirectional Relationship',
                'category'  => 'Sleep',
                'excerpt'   => 'Poor sleep affects mental health, and mental health affects sleep. Understanding this cycle is key to breaking it and improving both.',
                'body'      => '<p>The relationship between sleep and mental health is deeply intertwined. Sleep disturbances are both a symptom and a cause of many mental health conditions, creating cycles that can be challenging to break without proper support.</p><h2>How Sleep Affects Mental Health</h2><p>During sleep, the brain processes emotional experiences, consolidates memories, and clears metabolic waste products. Chronic sleep deprivation impairs emotional regulation, increases anxiety, and raises the risk of depression by up to 10 times.</p><h2>Sleep Hygiene Tips</h2><ul><li>Maintain consistent sleep and wake times</li><li>Create a cool, dark, quiet sleep environment</li><li>Avoid screens 1 hour before bed</li><li>Limit caffeine after 2 PM</li><li>Develop a calming pre-sleep routine</li></ul>',
                'read_time' => '5 min read',
            ],
            [
                'title'     => 'Building Resilience: Bouncing Back from Life\'s Challenges',
                'category'  => 'Self-care',
                'excerpt'   => 'Resilience is not about being immune to stress — it\'s about developing the skills to recover and grow stronger from adversity.',
                'body'      => '<p>Resilience is the ability to adapt and recover from adversity, trauma, tragedy, or significant stress. Contrary to popular belief, resilience is not a trait some people have and others don\'t — it\'s a set of behaviors and skills that can be learned and developed.</p><h2>The Four Pillars of Resilience</h2><ul><li><strong>Connection:</strong> Building and maintaining supportive relationships</li><li><strong>Wellness:</strong> Prioritizing physical and mental health</li><li><strong>Healthy Thinking:</strong> Cultivating realistic optimism</li><li><strong>Meaning:</strong> Finding purpose in difficult experiences</li></ul><h2>Practical Steps to Build Resilience</h2><p>Start by identifying your personal strengths and support network. Practice self-compassion — speak to yourself as you would to a good friend. Develop problem-solving skills and learn to reframe challenges as opportunities for growth.</p>',
                'read_time' => '8 min read',
            ],
        ];

        foreach ($articles as $article) {
            Resource::create(array_merge($article, [
                'author_id'    => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
            ]));
        }
    }
}
