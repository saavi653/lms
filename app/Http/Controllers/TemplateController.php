<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function  adminIndex()
    {
        $templates = Template::where('user_id',Auth::id())->get();

        return view('demo.templates.admin_index',['templates' => $templates]);
    }

    public function edit(Template $template)
    {
      
        return view('demo.templates.edit', ['template' => $template]);
    }

    public function update(Template $template,Request $request)
    {
        $attributes=$request->validate(
            [
                'name' => 'required|min:3|max:255|string' 
            ]
            );
          
        $template->update($attributes);

        return redirect()->route('admin_template.index')
            ->with('success','category updated successfully');
    }
    public function delete(Template $template)
    {
        $template->delete();

        return back()->with('success', 'template deleted successfully');
    }

    public function push(Template $template)
    {
       $template->where('parent_id', $template->id)->update([
        'name' => $template->name,
       ]);

        return back()->with('success', 'push succeffully done');
    }

   //functions related trainer

    public function index()
    {
        $templates = Template::where('user_id',Auth::id())->get();

        return view('demo.templates.index',['templates' => $templates]);
    }

    public function create(User $user )
    {
        $templates = Template::where('user_id', Role::ADMIN)->get();        
        foreach ($templates as $template) {

            $data = [
                'name' => $template->name,
                'user_id' => $user->id,
                'parent_id' => $template->id
            ];
            Template::insert($data);
        }
    }
}
