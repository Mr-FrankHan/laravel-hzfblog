<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Chat\Store;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Chat $chatModel)
    {
        $data = $chatModel
            ->orderBy('created_at', 'desc')
            ->withTrashed()
            ->paginate(50);
        $assign = compact('data');
        return view('admin.chat.index', $assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.chat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Chat $chatModel)
    {
        $data = $request->only(['content','image']);
        // 上传配图
        if ($request->hasFile('image')) {
            $result = upload('image', 'uploads/chat');
            if ($result['status_code'] === 200) {
                $data['image'] = $result['data']['path'].$result['data']['new_name'];
            }
        }
        $chatModel->storeData($data);
        return redirect('admin/chat/index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Chat::find($id);
        $assign = compact('data');
        return view('admin.chat.edit', $assign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Chat $chatModel)
    {
        $data = $request->except('_token');
        // 上传配图
        if ($request->hasFile('image')) {
            $result = upload('image', 'uploads/chat');
            if ($result['status_code'] === 200) {
                $data['image'] = $result['data']['path'].$result['data']['new_name'];
            }
        }
        $map = [
            'id' => $id
        ];
        $chatModel->updateData($map, $data);
        return redirect('admin/chat/index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Chat $chatModel)
    {
        $map = [
            'id' => $id
        ];
        $chatModel->destroyData($map);
        return redirect('admin/chat/index');
    }

    /**
     * 恢复删除的随言碎语
     *
     * @param      $id
     * @param Chat $chatModel
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id, Chat $chatModel)
    {
        $map = [
            'id' => $id
        ];
        $chatModel->restoreData($map);
        return redirect('admin/chat/index');
    }

    /**
     * 彻底删除随言碎语
     *
     * @param      $id
     * @param Chat $chatModel
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forceDelete($id, Chat $chatModel)
    {
        $map = compact('id');
        $chatModel->forceDeleteData($map);
        return redirect('admin/chat/index');
    }
}
