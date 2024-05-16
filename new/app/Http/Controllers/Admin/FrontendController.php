<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class FrontendController extends Controller {

    public function templates() {
        dd('text');
        $pageTitle = 'Templates';
        $temPaths  = array_filter(glob('core/resources/views/templates/*'), 'is_dir');
        foreach ($temPaths as $key => $temp) {
            $arr                      = explode('/', $temp);
            $tempname                 = end($arr);
            $templates[$key]['name']  = $tempname;
            $templates[$key]['image'] = asset($temp) . '/preview.jpg';
        }
        $extraTemplates = json_decode(getTemplates(), true);
        return view('admin.frontend.templates', compact('pageTitle', 'templates', 'extraTemplates'));
    }

    public function templatesActive(Request $request) {
        $general = gs();

        $general->active_template = $request->name;
        $general->save();

        $notify[] = ['success', strtoupper($request->name) . ' template activated successfully'];
        return back()->withNotify($notify);
    }

    public function seoEdit() {
        $pageTitle = 'SEO Configuration';
        $seo       = Frontend::where('data_keys', 'seo.data')->first();
        if (!$seo) {
            $data_values           = '{"keywords":[],"description":"","social_title":"","social_description":"","image":null}';
            $data_values           = json_decode($data_values, true);
            $frontend              = new Frontend();
            $frontend->data_keys   = 'seo.data';
            $frontend->data_values = $data_values;
            $frontend->save();
        }
        return view('admin.frontend.seo', compact('pageTitle', 'seo'));
    }

    public function frontendSections($key) {
        $section = @getPageSections()->$key;
        abort_if(!$section || !$section->builder, 404);

        $templates = Frontend::where('tempname', '!=', activeTemplate())->where('data_keys', 'like', $key . '.%')->distinct()->get('tempname')->pluck('tempname');
        $content   = Frontend::where('tempname', activeTemplate())->where('data_keys', $key . '.content')->orderBy('id', 'desc')->first();
        $elements  = Frontend::where('tempname', activeTemplate())->where('data_keys', $key . '.element')->orderBy('id')->orderBy('id', 'desc')->get();
        $pageTitle = $section->name;
        return view('admin.frontend.index', compact('section', 'content', 'elements', 'key', 'pageTitle', 'templates'));
    }

    public function frontendContent(Request $request, $key) {
        $purifier  = new \HTMLPurifier();
        $valInputs = $request->except('_token', 'image_input', 'key', 'status', 'type', 'id');
        foreach ($valInputs as $keyName => $input) {
            if (gettype($input) == 'array') {
                $inputContentValue[$keyName] = $input;
                continue;
            }
            $inputContentValue[$keyName] = htmlspecialchars_decode($purifier->purify($input));
        }
        $type = $request->type;
        if (!$type) {
            abort(404);
        }
        $imgJson           = @getPageSections()->$key->$type->images;
        $validationRule    = [];
        $validationMessage = [];
        foreach ($request->except('_token', 'video') as $inputField => $val) {
            if ($inputField == 'has_image' && $imgJson) {
                foreach ($imgJson as $imgValKey => $imgJsonVal) {
                    $validationRule['image_input.' . $imgValKey]               = ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])];
                    $validationMessage['image_input.' . $imgValKey . '.image'] = keyToTitle($imgValKey) . ' must be an image';
                    $validationMessage['image_input.' . $imgValKey . '.mimes'] = keyToTitle($imgValKey) . ' file type not supported';
                }
                continue;
            } else if ($inputField == 'seo_image') {
                $validationRule['image_input'] = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
                continue;
            }
            $validationRule[$inputField] = 'required';
        }
        $request->validate($validationRule, $validationMessage, ['image_input' => 'image']);
        if ($request->id) {
            $content = Frontend::where('tempname', activeTemplate())->findOrFail($request->id);
        } else {
            if ($request->type == 'data') {
                $content = Frontend::where('tempname', 'global')->where('data_keys', $key . '.' . $request->type)->first();
            } else {
                $content = Frontend::where('tempname', activeTemplate())->where('data_keys', $key . '.' . $request->type)->first();
            }

            if (!$content || $request->type == 'element') {
                $content            = new Frontend();
                $content->data_keys = $key . '.' . $request->type;
                $content->save();
            }
        }
        if ($type == 'data') {
            $inputContentValue['image'] = @$content->data_values->image;
            if ($request->hasFile('image_input')) {
                try {
                    $inputContentValue['image'] = fileUploader($request->image_input, getFilePath('seo'), getFileSize('seo'), @$content->data_values->image);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload the image'];
                    return back()->withNotify($notify);
                }
            }
        } else {
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    $imgData = @$request->image_input[$imgKey];
                    if (is_file($imgData)) {
                        try {
                            $inputContentValue[$imgKey] = $this->storeImage($imgJson, $type, $key, $imgData, $imgKey, @$content->data_values->$imgKey);
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Couldn\'t upload the image'];
                            return back()->withNotify($notify);
                        }
                    } else if (isset($content->data_values->$imgKey)) {
                        $inputContentValue[$imgKey] = $content->data_values->$imgKey;
                    }
                }
            }
        }
        $content->data_values = $inputContentValue;
        if ($request->type != 'data') {
            $content->tempname = activeTemplate();
        }
        $content->save();
        $notify[] = ['success', 'Content updated successfully'];
        return back()->withNotify($notify);
    }
    public function frontendElement($key, $id = null) {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }

        unset($section->element->modal);
        $pageTitle = $section->name . ' Items';
        if ($id) {
            $data = Frontend::findOrFail($id);
            return view('admin.frontend.element', compact('section', 'key', 'pageTitle', 'data'));
        }
        return view('admin.frontend.element', compact('section', 'key', 'pageTitle'));
    }

    protected function storeImage($imgJson, $type, $key, $image, $imgKey, $old_image = null) {
        $path = 'assets/images/frontend/' . $key;
        if ($type == 'element' || $type == 'content') {
            $size = @$imgJson
                ->$imgKey->size;
            $thumb = @$imgJson
                ->$imgKey->thumb;
        } else {
            $path  = getFilePath($key);
            $size  = getFileSize($key);
            $thumb = @fileManager()->$key()->thumb;
        }
        return fileUploader($image, $path, $size, $old_image, $thumb);
    }

    public function remove($id) {
        $frontend = Frontend::findOrFail($id);
        $key      = explode('.', @$frontend->data_keys)[0];
        $type     = explode('.', @$frontend->data_keys)[1];
        if (@$type == 'element' || @$type == 'content') {
            $path    = 'assets/images/frontend/' . $key;
            $imgJson = @getPageSections()->$key->$type->imaglistes;
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    fileManager()->removeFile($path . '/' . @$frontend->data_values->$imgKey);
                    fileManager()->removeFile($path . '/thumb_' . @$frontend->data_values->$imgKey);
                }
            }
        }
        $frontend->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }
    public function importContent(Request $request, $key) {

        $temPaths = array_filter(glob('core/resources/views/templates/*'), 'is_dir');
        foreach ($temPaths as $temp) {
            $arr         = explode('/', $temp);
            $tempname    = end($arr);
            $templates[] = "templates.$tempname.";
        }

        $request->validate([
            'tempname' => 'required|in:' . implode(',', $templates),
        ]);

        $fromTemp     = $request->tempname;
        $toTemp       = activeTemplate();
        $fromTempJson = json_decode(json_encode(getPageSections(false, str_replace('.', '/', $fromTemp))), true);
        $toTempJson   = json_decode(json_encode(getPageSections()), true)[$key];

        if (!array_key_exists($key, $fromTempJson)) {
            $notify[] = ['error', 'Key doesn\'t exists'];
            return back()->withNotify($notify);
        }

        $dataContent = Frontend::where('tempname', $fromTemp)->where('data_keys', $key . '.content')->first();
        if ($dataContent) {
            $toContentData = [];
            if (@$toTempJson['content']) {
                foreach ($toTempJson['content'] as $toContentKey => $toContentValue) {
                    if ($toContentKey == 'images') {
                        foreach ($toContentValue as $imageKey => $imageValue) {
                            $toContentData[$imageKey] = '';
                        }
                    } else {
                        $toContentData[$toContentKey] = @$dataContent->data_values->$toContentKey;
                    }
                }
                $toFrontendContent = Frontend::where('tempname', $toTemp)->where('data_keys', $key . '.content')->first();

                if ($toFrontendContent) {
                    foreach (@$toTempJson['content']['images'] ?? [] as $tempImageKey => $tempImage) {
                        $oldImage = $toFrontendContent->data_values->$tempImageKey;
                        $path     = 'assets/images/frontend/' . $key;
                        fileManager()->removeFile($path . '/' . @$oldImage);
                        fileManager()->removeFile($path . '/thumb_' . @$oldImage);
                    }
                }

                if (!$toFrontendContent) {
                    $toFrontendContent = new Frontend();
                }
                $toFrontendContent->data_keys   = $key . '.content';
                $toFrontendContent->data_values = $toContentData;
                $toFrontendContent->tempname    = $toTemp;
                $toFrontendContent->save();
            }
        }

        if (@$toTempJson['element']) {
            $dataElement      = Frontend::where('data_keys', $key . '.element')->where('tempname', $fromTemp)->get();
            $previousElements = Frontend::where('tempname', $toTemp)->where('data_keys', $key . '.element')->get();

            foreach ($previousElements as $prevElement) {
                foreach (@$toTempJson['element']['images'] ?? [] as $toElementKey => $toElementValue) {
                    $prevImage = $prevElement->data_values->$toElementKey;

                    $path = 'assets/images/frontend/' . $key;
                    fileManager()->removeFile($path . '/' . @$prevImage);
                    fileManager()->removeFile($path . '/thumb_' . @$prevImage);
                }
                $prevElement->delete();
            }

            foreach ($dataElement as $dataEl) {
                $toElementData = [];
                foreach ($toTempJson['element'] as $toElementKey => $toElementValue) {
                    if (in_array($toElementKey, ['modal'])) {
                        continue;
                    }
                    if ($toElementKey == 'images') {
                        foreach ($toElementValue as $imageKey => $imageValue) {
                            $toElementData[$imageKey] = '';
                        }
                    } else {
                        $toElementData[$toElementKey] = @$dataEl->data_values->$toElementKey;
                    }
                }
                $toFrontendElement              = new Frontend();
                $toFrontendElement->data_keys   = $key . '.element';
                $toFrontendElement->data_values = $toElementData;
                $toFrontendElement->tempname    = $toTemp;
                $toFrontendElement->save();
            }
        }

        $notify[] = ['success', 'Template updated successfully'];
        return back()->withNotify($notify);
    }
}
