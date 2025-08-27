<div class="nav-header">
    <a href="/" class="brand-logo">
       <img src="/admin/main/logo.webp" class="img-fluid brand-title">
    </a>
    <div class="nav-control">
       <div class="hamburger">
          <span class="line">
             <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.7468 5.58925C11.0722 5.26381 11.0722 4.73617 10.7468 4.41073C10.4213 4.0853 9.89369 4.0853 9.56826 4.41073L4.56826 9.41073C4.25277 9.72622 4.24174 10.2342 4.54322 10.5631L9.12655 15.5631C9.43754 15.9024 9.96468 15.9253 10.3039 15.6143C10.6432 15.3033 10.6661 14.7762 10.3551 14.4369L6.31096 10.0251L10.7468 5.58925Z" fill="#452B90"/>
                <path opacity="0.3" d="M16.5801 5.58924C16.9056 5.26381 16.9056 4.73617 16.5801 4.41073C16.2547 4.0853 15.727 4.0853 15.4016 4.41073L10.4016 9.41073C10.0861 9.72622 10.0751 10.2342 10.3766 10.5631L14.9599 15.5631C15.2709 15.9024 15.798 15.9253 16.1373 15.6143C16.4766 15.3033 16.4995 14.7762 16.1885 14.4369L12.1443 10.0251L16.5801 5.58924Z" fill="#452B90"/>
             </svg>
          </span>
       </div>
    </div>
 </div>

 <div class="header">
    <div class="header-content">
       <nav class="navbar navbar-expand">
          <div class="collapse navbar-collapse justify-content-between">
             <div class="header-left">
             </div>
             <div class="header-right d-flex align-items-center">
                <ul class="navbar-nav">
                   <li class="nav-item ps-3">
                      <div class="dropdown header-profile2">
                         <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" >
                            <div class="header-info2 d-flex align-items-center">
                               <div class="header-media">
                                  <img src="/admin/images/user.jpg" alt="">
                               </div>
                            </div>
                         </a>
                         <div class="dropdown-menu dropdown-menu-end" style="">
                            <div class="card border-0 mb-0">
                               <div class="card-header py-2">
                                  <div class="products">
                                     <img src="images/user.jpg" class="avatar avatar-md" alt="">
                                     <div>
                                        <h6>{{ Auth::user()->name }}</h6>
                                        <span>{{ Auth::user()->roles}}</span>
                                     </div>
                                  </div>
                               </div>
                               <div class="card-body px-0 py-2">
                                  <a href="#" class="dropdown-item ai-icon ">
                                     <svg  width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9848 15.3462C8.11714 15.3462 4.81429 15.931 4.81429 18.2729C4.81429 20.6148 8.09619 21.2205 11.9848 21.2205C15.8524 21.2205 19.1543 20.6348 19.1543 18.2938C19.1543 15.9529 15.8733 15.3462 11.9848 15.3462Z" stroke="var(--primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9848 12.0059C14.5229 12.0059 16.58 9.94779 16.58 7.40969C16.58 4.8716 14.5229 2.81445 11.9848 2.81445C9.44667 2.81445 7.38857 4.8716 7.38857 7.40969C7.38 9.93922 9.42381 11.9973 11.9524 12.0059H11.9848Z" stroke="var(--primary)" stroke-width="1.42857" stroke-linecap="round" stroke-linejoin="round"/>
                                     </svg>
                                     <span class="ms-2">Profile </span>
                                  </a>
                               </div>
                               <div class="card-footer px-0 py-2">
                                  <a href="{{ route('login') }}" class="dropdown-item ai-icon">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                     </svg>
                                     <span class="ms-2">Logout </span>
                                  </a>
                               </div>
                            </div>
                         </div>
                      </div>
                   </li>
                </ul>
             </div>
          </div>
       </nav>
    </div>
 </div>
 <!--**********************************
    Header end ti-comment-alt
    ***********************************-->
 <!--**********************************
    Sidebar start
    ***********************************-->
 <div class="deznav">
    <div class="deznav-scroll">
       <ul class="metismenu" id="menu">
          <li class="menu-title">YOUR COMPANY</li>

          <li>
            <a href="/dashboard" class="" >
               <div class="menu-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.13478 20.7733V17.7156C9.13478 16.9351 9.77217 16.3023 10.5584 16.3023H13.4326C13.8102 16.3023 14.1723 16.4512 14.4393 16.7163C14.7063 16.9813 14.8563 17.3408 14.8563 17.7156V20.7733C14.8539 21.0978 14.9821 21.4099 15.2124 21.6402C15.4427 21.8705 15.756 22 16.0829 22H18.0438C18.9596 22.0024 19.8388 21.6428 20.4872 21.0008C21.1356 20.3588 21.5 19.487 21.5 18.5778V9.86686C21.5 9.13246 21.1721 8.43584 20.6046 7.96467L13.934 2.67587C12.7737 1.74856 11.1111 1.7785 9.98539 2.74698L3.46701 7.96467C2.87274 8.42195 2.51755 9.12064 2.5 9.86686V18.5689C2.5 20.4639 4.04738 22 5.95617 22H7.87229C8.55123 22 9.103 21.4562 9.10792 20.7822L9.13478 20.7733Z" fill="#90959F"/>
                 </svg>
               </div>
               <span class="nav-text">Dashboard</span>
            </a>
         </li>
         @if(Auth::guard('webadmin')->user()->roles == 'Admin' || Auth::guard('webadmin')->user()->roles == 'Manager')
          <li>
             <a href="/university" class="" >
                <div class="menu-icon">
                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_113_177)">
                         <path d="M17 4H6C4.79111 4 4 4.7 4 6V18C4 19.3 4.79111 20 6 20H18C19.2 20 20 19.3 20 18V7.20711C20 7.0745 19.9473 6.94732 19.8536 6.85355L17 4ZM17 11H7V4H17V11Z" fill="#90959F"/>
                         <path opacity="0.3" d="M14.5 4H12.5C12.2239 4 12 4.22386 12 4.5V8.5C12 8.77614 12.2239 9 12.5 9H14.5C14.7761 9 15 8.77614 15 8.5V4.5C15 4.22386 14.7761 4 14.5 4Z" fill="white"/>
                      </g>
                      <defs>
                         <clipPath id="clip0_113_177">
                            <rect width="24" height="24" fill="white"/>
                         </clipPath>
                      </defs>
                   </svg>
                </div>
                <span class="nav-text">University</span>
             </a>
          </li>
          <li>
            <a href="/course" class="" >
               <div class="menu-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <g clip-path="url(#clip0_113_177)">
                        <path d="M17 4H6C4.79111 4 4 4.7 4 6V18C4 19.3 4.79111 20 6 20H18C19.2 20 20 19.3 20 18V7.20711C20 7.0745 19.9473 6.94732 19.8536 6.85355L17 4ZM17 11H7V4H17V11Z" fill="#90959F"/>
                        <path opacity="0.3" d="M14.5 4H12.5C12.2239 4 12 4.22386 12 4.5V8.5C12 8.77614 12.2239 9 12.5 9H14.5C14.7761 9 15 8.77614 15 8.5V4.5C15 4.22386 14.7761 4 14.5 4Z" fill="white"/>
                     </g>
                     <defs>
                        <clipPath id="clip0_113_177">
                           <rect width="24" height="24" fill="white"/>
                        </clipPath>
                     </defs>
                  </svg>
               </div>
               <span class="nav-text">Course</span>
            </a>
         </li>
         @endif
         @if(Auth::guard('webadmin')->user()->roles == 'Admin')
         <li>
            <a href="/user" class="" >
               <div class="menu-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <g clip-path="url(#clip0_113_177)">
                        <path d="M17 4H6C4.79111 4 4 4.7 4 6V18C4 19.3 4.79111 20 6 20H18C19.2 20 20 19.3 20 18V7.20711C20 7.0745 19.9473 6.94732 19.8536 6.85355L17 4ZM17 11H7V4H17V11Z" fill="#90959F"/>
                        <path opacity="0.3" d="M14.5 4H12.5C12.2239 4 12 4.22386 12 4.5V8.5C12 8.77614 12.2239 9 12.5 9H14.5C14.7761 9 15 8.77614 15 8.5V4.5C15 4.22386 14.7761 4 14.5 4Z" fill="white"/>
                     </g>
                     <defs>
                        <clipPath id="clip0_113_177">
                           <rect width="24" height="24" fill="white"/>
                        </clipPath>
                     </defs>
                  </svg>
               </div>
               <span class="nav-text">Users</span>
            </a>
         </li>
         @endif
         <li>
            <a href="/student" class="" >
               <div class="menu-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <g clip-path="url(#clip0_113_177)">
                        <path d="M17 4H6C4.79111 4 4 4.7 4 6V18C4 19.3 4.79111 20 6 20H18C19.2 20 20 19.3 20 18V7.20711C20 7.0745 19.9473 6.94732 19.8536 6.85355L17 4ZM17 11H7V4H17V11Z" fill="#90959F"/>
                        <path opacity="0.3" d="M14.5 4H12.5C12.2239 4 12 4.22386 12 4.5V8.5C12 8.77614 12.2239 9 12.5 9H14.5C14.7761 9 15 8.77614 15 8.5V4.5C15 4.22386 14.7761 4 14.5 4Z" fill="white"/>
                     </g>
                     <defs>
                        <clipPath id="clip0_113_177">
                           <rect width="24" height="24" fill="white"/>
                        </clipPath>
                     </defs>
                  </svg>
               </div>
               <span class="nav-text">Student</span>
            </a>
         </li>
         


          <li>
             <a class="has-arrow " href="javascript:void(0);" >
                <div class="menu-icon">
                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g opacity="0.5">
                         <path opacity="0.4" d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z" fill="white"/>
                         <path fill-rule="evenodd" clip-rule="evenodd" d="M8.08002 6.64999V6.65999C7.64902 6.65999 7.30002 7.00999 7.30002 7.43999C7.30002 7.86999 7.64902 8.21999 8.08002 8.21999H11.069C11.5 8.21999 11.85 7.86999 11.85 7.42899C11.85 6.99999 11.5 6.64999 11.069 6.64999H8.08002ZM15.92 12.74H8.08002C7.64902 12.74 7.30002 12.39 7.30002 11.96C7.30002 11.53 7.64902 11.179 8.08002 11.179H15.92C16.35 11.179 16.7 11.53 16.7 11.96C16.7 12.39 16.35 12.74 15.92 12.74ZM15.92 17.31H8.08002C7.78002 17.35 7.49002 17.2 7.33002 16.95C7.17002 16.69 7.17002 16.36 7.33002 16.11C7.49002 15.85 7.78002 15.71 8.08002 15.74H15.92C16.319 15.78 16.62 16.12 16.62 16.53C16.62 16.929 16.319 17.27 15.92 17.31Z" fill="white"/>
                      </g>
                   </svg>
                </div>
                <span class="nav-text">Ledgers</span>
             </a>
             <ul >
               <li><a href="/studentLedgers">Student Ledgers</a></li>
                <li><a href="form-element.html">Form Elements</a></li>
                <li><a href="form-wizard.html">Wizard</a></li>
                <li><a href="form-ckeditor.html">CkEditor</a></li>
                <li><a href="form-pickers.html">Pickers</a></li>
                <li><a href="form-validation.html">Form Validate</a></li>
             </ul>
          </li>
       </ul>
    </div>
 </div>
