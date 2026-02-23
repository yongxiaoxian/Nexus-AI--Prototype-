@extends('layouts.app')

@section('title', 'OCR Product Scan — NexusAI')
@section('description', 'Upload a product image and let AI extract product details instantly. Powered by NexusAI vision technology.')

@section('content')
    <section class="ocr-section">
        <div class="ocr-fullpage">
            {{-- Header --}}
            <div class="ocr-header">
                <div class="chat-header-info">
                    <div class="chat-avatar">
                        <svg width="24" height="24" viewBox="0 0 32 32" fill="none">
                            <defs>
                                <linearGradient id="ocrLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#00B894" />
                                    <stop offset="100%" style="stop-color:#00D2FF" />
                                </linearGradient>
                            </defs>
                            <rect width="32" height="32" rx="8" fill="url(#ocrLogoGrad)" />
                            <rect x="7" y="7" width="18" height="18" rx="3" stroke="white" stroke-width="1.5" fill="none" />
                            <circle cx="12" cy="12" r="2" fill="white" />
                            <polyline points="25 19 20 14 11 23" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                fill="none" />
                        </svg>
                    </div>
                    <div>
                        <span class="chat-header-name">OCR Product Scan</span>
                        <span class="chat-header-status"><span class="status-dot"></span> Ready</span>
                    </div>
                </div>
                <div class="demo-header-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    AI-Powered
                </div>
            </div>

            {{-- Step 1: Upload --}}
            <div class="ocr-step ocr-step-upload active" id="ocrStepUpload">
                <div class="ocr-upload-zone" id="ocrDropZone">
                    <div class="ocr-upload-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <polyline points="21 15 16 10 5 21" />
                        </svg>
                    </div>
                    <h2 class="ocr-upload-title">Upload Product Image</h2>
                    <p class="ocr-upload-desc">Drag and drop an image here, or click to browse</p>
                    <p class="ocr-upload-hint">Supports JPEG, PNG, WebP — Max 10MB</p>
                    <input type="file" id="ocrFileInput" accept="image/jpeg,image/png,image/webp" hidden>
                    <button class="btn btn-primary" id="ocrBrowseBtn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" y1="3" x2="12" y2="15" />
                        </svg>
                        Browse Files
                    </button>
                </div>

                {{-- Image Preview (hidden until image selected) --}}
                <div class="ocr-preview" id="ocrPreview" style="display:none">
                    <div class="ocr-preview-image-wrap">
                        <img id="ocrPreviewImg" alt="Product preview">
                    </div>
                    <div class="ocr-preview-actions">
                        <button class="btn btn-primary" id="ocrConfirmBtn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            Confirm & Analyze
                        </button>
                        <button class="btn btn-outline" id="ocrRemoveBtn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- Step 2: Processing --}}
            <div class="ocr-step ocr-step-processing" id="ocrStepProcessing">
                <div class="ocr-processing-content">
                    <div class="ocr-spinner">
                        <div class="ocr-spinner-ring"></div>
                        <svg class="ocr-spinner-icon" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <polyline points="21 15 16 10 5 21" />
                        </svg>
                    </div>
                    <h2 class="ocr-processing-title">Analyzing Product</h2>
                    <p class="ocr-processing-desc" id="ocrProcessingText">Sending image to AI for analysis...</p>
                    <div class="ocr-processing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>

            {{-- Step 3: Product Details --}}
            <div class="ocr-step ocr-step-result" id="ocrStepResult">
                <div class="ocr-result-scroll">
                    <div class="ocr-result-layout">
                        {{-- Left: Image --}}
                        <div class="ocr-result-image-col">
                            <div class="ocr-result-image-wrap">
                                <img id="ocrResultImg" alt="Product image">
                            </div>
                            <button class="btn btn-outline btn-block" id="ocrScanAnother">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10" />
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" />
                                </svg>
                                Scan Another Product
                            </button>
                        </div>

                        {{-- Right: Form --}}
                        <div class="ocr-result-form-col">
                            <h2 class="ocr-result-heading">Product Details</h2>
                            <p class="ocr-result-subheading">AI-extracted information — all fields are editable</p>

                            <div class="ocr-form-group">
                                <label for="ocrProductName">Product Name</label>
                                <input type="text" id="ocrProductName" class="ocr-input" placeholder="Product name">
                            </div>

                            <div class="ocr-form-group">
                                <label for="ocrDescription">Description</label>
                                <textarea id="ocrDescription" class="ocr-input ocr-textarea" rows="4"
                                    placeholder="Product description"></textarea>
                            </div>

                            <div class="ocr-form-row">
                                <div class="ocr-form-group">
                                    <label for="ocrCategory">Category</label>
                                    <input type="text" id="ocrCategory" class="ocr-input" placeholder="Category">
                                </div>
                                <div class="ocr-form-group">
                                    <label for="ocrBrand">Brand</label>
                                    <input type="text" id="ocrBrand" class="ocr-input" placeholder="Brand">
                                </div>
                            </div>

                            <div class="ocr-form-group">
                                <label for="ocrCondition">Condition</label>
                                <select id="ocrCondition" class="ocr-input">
                                    <option value="New">New</option>
                                    <option value="Like New">Like New</option>
                                    <option value="Used" selected>Used</option>
                                    <option value="Refurbished">Refurbished</option>
                                    <option value="For Parts">For Parts</option>
                                </select>
                            </div>

                            <div class="ocr-form-row">
                                <div class="ocr-form-group">
                                    <label for="ocrPrice">Price (RM)</label>
                                    <input type="number" id="ocrPrice" class="ocr-input" value="0.00" min="0" step="0.01">
                                </div>
                                <div class="ocr-form-group">
                                    <label for="ocrUnit">Quantity / Unit</label>
                                    <input type="number" id="ocrUnit" class="ocr-input" value="1" min="1">
                                </div>
                            </div>

                            <button class="btn btn-primary btn-block" id="ocrCopyJson">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                                Copy as JSON
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection