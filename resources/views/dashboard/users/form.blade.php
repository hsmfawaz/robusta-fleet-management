<x-form :model="$model ?? null" route="users" :title="__('User')">
    <div class="row">
        <x-form.input name="name" label="Name" :value="$model?->name" required/>
        <x-form.input type="email" name="email" label="Email" :value="$model?->email" required/>
        <x-form.input type="password" name="password" label="Password"/>
        <x-form.input type="password" name="password_confirmation" label="Password Confirmation"/>
    </div>
</x-form>