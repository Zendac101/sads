from django.shortcuts import render, redirect
from django.contrib.auth.decorators import login_required
from .models import locationData


@login_required
def home_view(request):
    if not request.user.is_authenticated:

        return redirect('/accounts/registerUser')

    return render(request, 'home.html')


def analysis_view(request):
    if not request.user.is_authenticated:

        return redirect('/accounts/registerUser')

    dropdown_options = locationData.objects.using('sensor_data_db') \
        .values_list('site_id', 'site_name') \
        .order_by('site_name')

    return render(request, 'analysis.html', {'location_options': dropdown_options})


def data_management_view(request):
    if not request.user.is_authenticated:

        return redirect('/accounts/registerUser')

    dropdown_options = locationData.objects.using('sensor_data_db') \
        .values_list('site_id', 'site_name') \
        .order_by('site_name')

    return render(request, 'data_management.html', {'location_options': dropdown_options})


def report_view(request):
    if not request.user.is_authenticated:

        return redirect('/accounts/registerUser')

    return render(request, 'reports.html')


def settings_view(request):
    if not request.user.is_authenticated:

        return redirect('/accounts/registerUser')

    return render(request, 'settings.html')


def support_view(request):
    if not request.user.is_authenticated:

        return redirect('/accounts/registerUser')

    return render(request, 'support.html')
