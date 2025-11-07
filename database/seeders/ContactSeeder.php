<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'General Inquiry',
            'message' => 'Hello! I wanted to ask about the new games being added to the platform. Do you have any plans to include indie games from smaller developers?',
            'status' => 'pending',
        ]);

        Contact::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.j@email.com',
            'subject' => 'Bug Report',
            'message' => 'I found a bug where the wishlist doesn\'t update properly when I remove games. It seems to refresh only after I reload the page.',
            'status' => 'in_progress',
            'admin_response' => 'Thank you for reporting this. We are currently investigating the issue.',
            'responded_at' => now()->subHours(2),
            'responded_by' => 1,
        ]);

        Contact::create([
            'name' => 'Mike Chen',
            'email' => 'mike.chen@gmail.com',
            'subject' => 'Feature Request',
            'message' => 'It would be great if you could add a rating system for games, so users can rate and review games they\'ve played.',
            'status' => 'resolved',
            'admin_response' => 'Great suggestion! We\'ve added this to our roadmap for the next quarter.',
            'responded_at' => now()->subDays(1),
            'responded_by' => 1,
        ]);

        Contact::create([
            'name' => 'Emma Wilson',
            'email' => 'emma.w@hotmail.com',
            'subject' => 'Account Issue',
            'message' => 'I can\'t seem to log into my account. I\'ve tried resetting my password multiple times but the reset email never arrives.',
            'status' => 'pending',
        ]);

        Contact::create([
            'name' => 'David Rodriguez',
            'email' => 'david.rod@company.com',
            'subject' => 'Partnership',
            'message' => 'Hi, I represent a game development studio and we\'re interested in featuring our games on your platform. Could we discuss partnership opportunities?',
            'status' => 'closed',
            'admin_response' => 'Thank you for your interest. I\'ve forwarded your message to our business development team.',
            'responded_at' => now()->subDays(3),
            'responded_by' => 1,
        ]);
    }
}