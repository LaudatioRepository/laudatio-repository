@extends('layouts.auth_ux')

@section('content')


<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-6 offset-2">


                <div class="d-flex justify-content-between mt-7 mb-3">
                    <h3 class="h3 font-weight-normal">Registration step 1/3 - Sign in for GutLab and register your SSH Public Key</h3>
                </div>
                <div class="my-4">
                    <p>
                        To register for an account with Laudatio, you will firstly have to register a GitLab account at <a href="https://scm.cms.hu-berlin.de" target="_blank">https://scm.cms.hu-berlin.de</a>.
                        This is necessary in order to be able to save and get access to your content both inside the repository as well as directly from Humboldt-Universität zu Berlin's GitLab-installation.
                    </p>
                    <p>
                        Your user name in Laudatio will be the email address you used to register for GitLab with. For persons that already have an account as a user at Humboldt-Universität zu Berlin, the user name in Laudatio will be the HU email address.
                    </p>
                    <p>
                        Using Laudatio and publishing corpora in the Laudatio Repository is generally free of charge.
                    </p>
                    <p>
                        For further information, please see our
                        <a href="#"> Terms of use</a>.

                    </p>

                    <p class="h5 mt-7">
                        Step 1: If you don't have a HU-account or haven't registered for a GitLab account yet, register at  <a href="https://scm.cms.hu-berlin.de" target="_blank">https://scm.cms.hu-berlin.de</a>
                    </p>
                    <img src="/images/gitlab_register.png" alt="gitlab-register">

                    <p class="h5 mt-7">
                        Step 2. If you already have a HU-account, or you have registered for a new account, log into <a href="https://scm.cms.hu-berlin.de" target="_blank">https://scm.cms.hu-berlin.de</a> and register a <strong>SSH-key</strong>, which will enable you to authenticate without password with Gitlab.
                    </p>

                    <p class="mt-7">
                        <strong>Step 2.1:</strong>  If you do not already have an SSH-key, navigate to <a href="https://scm.cms.hu-berlin.de/help/ssh/README#generating-a-new-ssh-key-pair" target="_blank">https://scm.cms.hu-berlin.de/help/ssh/README#generating-a-new-ssh-key-pair</a>,
                        and follow the instructions under <strong>"Generating a new SSH key pair"</strong>
                    </p>

                    <p>If you already have an SSH key you want to use, the following link contains some tips that can help <a href="https://scm.cms.hu-berlin.de/help/ssh/README#locating-an-existing-ssh-key-pair" target="_blank">locating your SSH-key</a></p>


                    <p class="mt-7">
                        Step 2.2: With your SSH public key ready, navigate to <a href="https://scm.cms.hu-berlin.de/profile/keys" target="_blank">https://scm.cms.hu-berlin.de/profile/keys</a>,
                        and follow the instructions under <strong>"SSH Key"</strong>
                    </p>
                    <img src="/images/register_ssh_key.png" alt="gitlab-register">

                    <p class="h5 font-weight-bold mt-7">
                        Step 3. When you have successfully registered your public ssh-key with your gitlab account;
                    </p>

                    <a href="{{ route('registerform') }}" class="btn btn-primary rounded text-uppercase font-weight-bold my-3 mr-3">
                        Continue to registration form
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection