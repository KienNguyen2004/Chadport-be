<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CommentsController extends Controller
{
    // hàm này post comments
    public function createComments(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'rating' => 'nullable|integer|max:5',
            'like_count' => 'integer|min:0',
            'dislike_count' => 'integer|min:0',
            'reported' => 'boolean',
        ]);
    
        // Tạo mới comment
        $comment = Comment::create($validatedData);
    
        // Trả về response
        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment,
        ], 201);
    }

    // hàm lấy all commentsL
    public function getCommentsByProduct($product_id) {
        // Lấy tất cả các bình luận của một sản phẩm cụ thể
        $comments = Comment::where('product_id', $product_id)
                           ->with('user') // Sử dụng eager loading để lấy thông tin user nếu cần
                           ->get();
    
        return response()->json([
            'data' => $comments,
        ], 200);
    }
    
    // Hàm xóa comment
    public function deleteComment(Request $request, $comment_id)
    {
        // Tìm comment
        $comment = Comment::find($comment_id);

        // Kiểm tra nếu comment không tồn tại
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found',
            ], 404);
        }

        // Kiểm tra nếu user_id trong request khớp với user_id của comment
        if ($comment->user_id != $request->input('user_id') || $comment->product_id != $request->input('product_id')) {
            return response()->json([
                'message' => 'Unauthorized to delete this comment',
            ], 403);
        }

        // Xóa comment
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
        ], 200);
    }


}
