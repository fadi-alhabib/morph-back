<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $contact = ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Contact message created successfully!',
            'data' => $contact,
        ], 201);
    }

    public function index()
    {
        try {
            $contacts = ContactUs::all();
            return response()->json([
                'message' => 'Contacts retrieved successfully!',
                'data' => $contacts,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
            ]);
        }
    }

    public function show($id)
    {
        $contact = ContactUs::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Contact not found!',
            ], 404);
        }

        return response()->json([
            'message' => 'Contact retrieved successfully!',
            'data' => $contact,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'message' => 'sometimes|string',
        ]);

        $contact = ContactUs::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Contact not found!',
            ], 404);
        }

        $contact->update($request->only(['name', 'email', 'message']));

        return response()->json([
            'message' => 'Contact updated successfully!',
            'data' => $contact,
        ], 200);
    }

    public function destroy($id)
    {
        $contact = ContactUs::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Contact not found!',
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully!',
        ], 200);
    }
}
